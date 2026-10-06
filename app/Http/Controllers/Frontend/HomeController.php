<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use App\Models\Page;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Testimonial;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $page = Page::query()
            ->where('slug', 'home')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $heroSlides = HeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $featuredServices = Service::query()
            ->with('category')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->limit(6)
            ->get();

        $serviceCategories = ServiceCategory::query()
            ->where('is_active', true)
            ->withCount([
                'services' => fn ($query) => $query
                    ->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $testimonials = Testimonial::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('frontend.pages.home', compact(
            'page',
            'sections',
            'heroSlides',
            'featuredServices',
            'serviceCategories',
            'testimonials'
        ));
    }
}
