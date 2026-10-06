<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AcademyController extends Controller
{
    public function index(Request $request): View
    {
        $page = Page::query()
            ->where('slug', 'academy')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $categorySlug = $request
            ->string('category')
            ->toString();

        $categories = CourseCategory::query()
            ->where('is_active', true)
            ->withCount([
                'courses' => fn ($query) => $query
                    ->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $courses = Course::query()
            ->with('category')
            ->where('is_published', true)
            ->when($categorySlug, function ($query) use ($categorySlug) {
                $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery
                        ->where('slug', $categorySlug)
                );
            })
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.pages.academy.index', compact(
            'page',
            'sections',
            'categories',
            'courses',
            'categorySlug'
        ));
    }

    public function show(Course $course): View
    {
        abort_unless($course->is_published, 404);

        $course->increment('views');
        $course->load('category');

        $relatedCourses = Course::query()
            ->with('category')
            ->where('is_published', true)
            ->whereKeyNot($course->getKey())
            ->when(
                $course->course_category_id,
                fn ($query) => $query->where(
                    'course_category_id',
                    $course->course_category_id
                )
            )
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('frontend.pages.academy.show', compact(
            'course',
            'relatedCourses'
        ));
    }
}
