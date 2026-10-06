<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $categories = ProductCategory::query()
            ->withCount('products')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.product-categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create(): View
    {
        return view('admin.product-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('product-categories', 'public');
        }

        unset($validated['remove_image']);

        ProductCategory::create($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category created successfully.');
    }

    public function show(ProductCategory $productCategory): View
    {
        $productCategory->loadCount('products');

        return view(
            'admin.product-categories.show',
            compact('productCategory')
        );
    }

    public function edit(ProductCategory $productCategory): View
    {
        return view(
            'admin.product-categories.edit',
            compact('productCategory')
        );
    }

    public function update(
        Request $request,
        ProductCategory $productCategory
    ): RedirectResponse {
        $validated = $this->validateCategory(
            $request,
            $productCategory
        );

        $slugSource = $validated['slug']
            ?: $validated['name'];

        $validated['slug'] = $this->uniqueSlug(
            $slugSource,
            $productCategory->id
        );

        $validated['is_active'] = $request->boolean('is_active');

        if ($request->boolean('remove_image')) {
            $this->deleteImage($productCategory->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($productCategory->image);

            $validated['image'] = $request
                ->file('image')
                ->store('product-categories', 'public');
        }

        unset($validated['remove_image']);

        $productCategory->update($validated);

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category updated successfully.');
    }

    public function destroy(
        ProductCategory $productCategory
    ): RedirectResponse {
        if ($productCategory->products()->exists()) {
            return back()->with(
                'error',
                'This category contains products. Move or delete those products before deleting the category.'
            );
        }

        $productCategory->delete();

        return redirect()
            ->route('admin.product-categories.index')
            ->with('success', 'Product category deleted successfully.');
    }

    private function validateCategory(
        Request $request,
        ?ProductCategory $productCategory = null
    ): array {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:180',
                Rule::unique('product_categories', 'slug')
                    ->ignore($productCategory?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'remove_image' => [
                'nullable',
                'boolean',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000',
            ],
        ]);
    }

    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'category';
        $slug = $baseSlug;
        $counter = 2;

        while (
            ProductCategory::query()
                ->when(
                    $ignoreId,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $image): void
    {
        if (
            $image
            && Storage::disk('public')->exists($image)
        ) {
            Storage::disk('public')->delete($image);
        }
    }
}
