<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $page = Page::query()
            ->where('slug', 'products')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $categorySlug = $request->string('category')->toString();

        $categories = ProductCategory::query()
            ->where('is_active', true)
            ->withCount([
                'products' => fn ($query) => $query
                    ->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('is_published', true)
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.products.index', compact(
            'page',
            'sections',
            'categories',
            'products',
            'categorySlug'
        ));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_published, 404);

        $product->increment('views');

        $product->load('category');

        $relatedProducts = Product::query()
            ->with('category')
            ->where('is_published', true)
            ->whereKeyNot($product->getKey())
            ->when(
                $product->product_category_id,
                fn ($query) => $query->where(
                    'product_category_id',
                    $product->product_category_id
                )
            )
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('frontend.pages.products.show', compact(
            'product',
            'relatedProducts'
        ));
    }
}
