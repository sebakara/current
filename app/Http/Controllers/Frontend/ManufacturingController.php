<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Service;
use Illuminate\View\View;

class ManufacturingController extends Controller
{
    public function index(): View
    {
        $page = Page::query()
            ->where('slug', 'manufacturing')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $manufacturingServices = Service::query()
            ->with('category')
            ->where('is_published', true)
            ->whereHas('category', function ($query) {
                $query->where(function ($builder) {
                    $builder
                        ->where('slug', 'manufacturing')
                        ->orWhere('name', 'like', '%manufactur%')
                        ->orWhere('name', 'like', '%fabrication%');
                });
            })
            ->orderBy('sort_order')
            ->limit(8)
            ->get();

        return view('frontend.pages.manufacturing', compact(
            'page',
            'sections',
            'manufacturingServices'
        ));
    }
}
