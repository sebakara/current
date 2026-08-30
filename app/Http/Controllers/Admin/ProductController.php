<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->integer('category');
        $status = (string) $request->query('status', 'all');

        $products = Product::query()
            ->with('category')
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when(
                $categoryId > 0,
                fn (Builder $query) => $query->where(
                    'product_category_id',
                    $categoryId
                )
            )
            ->when(
                $status === 'published',
                fn (Builder $query) => $query->where('is_published', true)
            )
            ->when(
                $status === 'draft',
                fn (Builder $query) => $query->where('is_published', false)
            )
            ->when(
                $status === 'featured',
                fn (Builder $query) => $query->where('is_featured', true)
            )
            ->when(
                $status === 'out-of-stock',
                fn (Builder $query) => $query
                    ->where('manage_stock', true)
                    ->where('allow_backorders', false)
                    ->where('stock_quantity', '<=', 0)
            )
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $categories = ProductCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.products.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProduct($request);

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $validated['gallery'] = collect(
                $request->file('gallery_images')
            )
                ->map(
                    fn ($image) => $image->store(
                        'products/gallery',
                        'public'
                    )
                )
                ->values()
                ->all();
        }

        if ($request->hasFile('datasheet')) {
            $validated['datasheet'] = $request
                ->file('datasheet')
                ->store('products/datasheets', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product): View
    {
        $product->load('category');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('category');

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $this->categories(),
        ]);
    }

    public function update(
        Request $request,
        Product $product
    ): RedirectResponse {
        $validated = $this->validateProduct(
            $request,
            $product
        );

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $product->id
        );

        if ($request->boolean('remove_featured_image')) {
            $this->deletePublicFile($product->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $this->deletePublicFile($product->featured_image);

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('products/featured', 'public');
        }

        $gallery = collect($product->gallery ?? []);

        $removeGalleryImages = collect(
            $request->input('remove_gallery_images', [])
        );

        foreach ($removeGalleryImages as $image) {
            if ($gallery->contains($image)) {
                $this->deletePublicFile($image);
                $gallery = $gallery->reject(
                    fn ($existingImage) => $existingImage === $image
                );
            }
        }

        if ($request->boolean('remove_all_gallery_images')) {
            $gallery->each(
                fn ($image) => $this->deletePublicFile($image)
            );

            $gallery = collect();
        }

        if ($request->hasFile('gallery_images')) {
            $newImages = collect(
                $request->file('gallery_images')
            )->map(
                fn ($image) => $image->store(
                    'products/gallery',
                    'public'
                )
            );

            $gallery = $gallery->merge($newImages);
        }

        $validated['gallery'] = $gallery
            ->filter()
            ->values()
            ->all();

        if ($request->boolean('remove_datasheet')) {
            $this->deletePublicFile($product->datasheet);
            $validated['datasheet'] = null;
        }

        if ($request->hasFile('datasheet')) {
            $this->deletePublicFile($product->datasheet);

            $validated['datasheet'] = $request
                ->file('datasheet')
                ->store('products/datasheets', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function validateProduct(
        Request $request,
        ?Product $product = null
    ): array {
        $validated = $request->validate([
            'product_category_id' => [
                'required',
                'integer',
                Rule::exists('product_categories', 'id')
                    ->whereNull('deleted_at'),
            ],
            'name' => [
                'required',
                'string',
                'max:180',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:200',
                Rule::unique('products', 'slug')
                    ->ignore($product?->id),
            ],
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products', 'sku')
                    ->ignore($product?->id),
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'description' => [
                'nullable',
                'string',
                'max:30000',
            ],
            'features_text' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'specifications_text' => [
                'nullable',
                'string',
                'max:15000',
            ],
            'options_text' => [
                'nullable',
                'string',
                'max:15000',
            ],
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'gallery_images' => [
                'nullable',
                'array',
                'max:20',
            ],
            'gallery_images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'remove_gallery_images' => [
                'nullable',
                'array',
            ],
            'remove_gallery_images.*' => [
                'string',
                'max:500',
            ],
            'remove_featured_image' => [
                'nullable',
                'boolean',
            ],
            'remove_all_gallery_images' => [
                'nullable',
                'boolean',
            ],
            'video_url' => [
                'nullable',
                'url',
                'max:1000',
            ],
            'datasheet' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx',
                'max:15360',
            ],
            'remove_datasheet' => [
                'nullable',
                'boolean',
            ],
            'price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999',
            ],
            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999',
            ],
            'currency' => [
                'required',
                'string',
                'max:10',
            ],
            'minimum_order_quantity' => [
                'required',
                'integer',
                'min:1',
                'max:1000000',
            ],
            'stock_quantity' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000000',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000',
            ],
            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],
            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],
            'show_price' => [
                'nullable',
                'boolean',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'is_published' => [
                'nullable',
                'boolean',
            ],
            'manage_stock' => [
                'nullable',
                'boolean',
            ],
            'allow_backorders' => [
                'nullable',
                'boolean',
            ],
            'cart_enabled' => [
                'nullable',
                'boolean',
            ],
            'whatsapp_order_enabled' => [
                'nullable',
                'boolean',
            ],
        ]);

        if (
            isset($validated['sale_price'])
            && $validated['sale_price'] !== null
            && isset($validated['price'])
            && $validated['price'] !== null
            && (float) $validated['sale_price'] > (float) $validated['price']
        ) {
            throw ValidationException::withMessages([
                'sale_price' => 'The sale price cannot be greater than the regular price.',
            ]);
        }

        return $validated;
    }

    private function prepareData(
        Request $request,
        array $validated
    ): array {
        $validated['features'] = $this->parseFeatures(
            $request->input('features_text')
        );

        $validated['specifications'] = $this->parseSpecifications(
            $request->input('specifications_text')
        );

        $validated['options'] = $this->parseOptions(
            $request->input('options_text')
        );

        $validated['show_price'] = $request->boolean('show_price');
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_published'] = $request->boolean('is_published');
        $validated['manage_stock'] = $request->boolean('manage_stock');
        $validated['allow_backorders'] = $request->boolean('allow_backorders');
        $validated['cart_enabled'] = $request->boolean('cart_enabled');
        $validated['whatsapp_order_enabled'] = $request->boolean(
            'whatsapp_order_enabled'
        );

        $validated['stock_quantity'] = $validated['manage_stock']
            ? (int) ($validated['stock_quantity'] ?? 0)
            : 0;

        $validated['minimum_order_quantity'] = max(
            1,
            (int) ($validated['minimum_order_quantity'] ?? 1)
        );

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated['currency'] = Str::upper(
            trim($validated['currency'] ?: 'RWF')
        );

        foreach ([
            'features_text',
            'specifications_text',
            'options_text',
            'remove_featured_image',
            'remove_all_gallery_images',
            'remove_gallery_images',
            'remove_datasheet',
        ] as $field) {
            unset($validated[$field]);
        }

        return $validated;
    }

    private function parseFeatures(?string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value ?? ''))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function parseSpecifications(?string $value): array
    {
        $specifications = [];

        foreach (
            preg_split('/\r\n|\r|\n/', $value ?? '')
            as $line
        ) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            [$label, $specificationValue] = array_pad(
                explode(':', $line, 2),
                2,
                null
            );

            $label = trim((string) $label);
            $specificationValue = trim(
                (string) $specificationValue
            );

            if ($label !== '' && $specificationValue !== '') {
                $specifications[$label] = $specificationValue;
            }
        }

        return $specifications;
    }

    private function parseOptions(?string $value): array
    {
        $options = [];

        foreach (
            preg_split('/\r\n|\r|\n/', $value ?? '')
            as $line
        ) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            [$name, $valuesString] = array_pad(
                explode(':', $line, 2),
                2,
                null
            );

            $name = trim((string) $name);

            $values = collect(
                explode(',', (string) $valuesString)
            )
                ->map(fn ($option) => trim($option))
                ->filter()
                ->unique()
                ->values()
                ->all();

            if ($name !== '' && ! empty($values)) {
                $options[] = [
                    'name' => $name,
                    'values' => $values,
                ];
            }
        }

        return $options;
    }

    private function categories()
    {
        return ProductCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'product';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Product::query()
                ->withTrashed()
                ->when(
                    $ignoreId,
                    fn (Builder $query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deletePublicFile(?string $path): void
    {
        if (
            $path
            && Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}
