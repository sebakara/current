<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use Illuminate\View\View;

class VtlWoodsController extends Controller
{
    public function index(): View
    {
        $page = Page::query()
            ->where('slug', 'vtl-woods')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $woodProducts = Product::query()
            ->with('category')
            ->where('is_published', true)
            ->where(function ($query) {
                $query
                    ->whereHas('category', function ($categoryQuery) {
                        $categoryQuery
                            ->where('slug', 'vtl-woods')
                            ->orWhere('name', 'like', '%wood%')
                            ->orWhere('name', 'like', '%furniture%');
                    })
                    ->orWhere('name', 'like', '%wood%')
                    ->orWhere('name', 'like', '%furniture%')
                    ->orWhere('description', 'like', '%wood%')
                    ->orWhere('description', 'like', '%furniture%');
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('frontend.pages.vtl-woods', compact(
            'page',
            'sections',
            'woodProducts'
        ));
    }
}
