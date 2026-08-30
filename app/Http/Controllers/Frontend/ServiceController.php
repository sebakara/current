<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $categorySlug = $request->string('category')->toString();

        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $services = Service::query()
            ->with('category')
            ->where('is_published', true)
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                    $categoryQuery->where('slug', $categorySlug);
                });
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.services.index', compact(
            'services',
            'categories',
            'categorySlug'
        ));
    }

    public function show(Service $service): View
    {
        abort_unless($service->is_published, 404);

        $service->load('category');

        $relatedServices = Service::query()
            ->with('category')
            ->where('is_published', true)
            ->whereKeyNot($service->id)
            ->when(
                $service->service_category_id,
                fn ($query) => $query->where(
                    'service_category_id',
                    $service->service_category_id
                )
            )
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        $service->increment('views');

        return view('frontend.pages.services.show', compact(
            'service',
            'relatedServices'
        ));
    }
}
