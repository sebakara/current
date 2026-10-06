<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $page = Page::query()
            ->where('slug', 'projects')
            ->where('is_published', true)
            ->with('activeSections')
            ->first();

        $sections = $page
            ? $page->activeSections->keyBy('section_key')
            : collect();

        $categorySlug = $request
            ->string('category')
            ->toString();

        $categories = ProjectCategory::query()
            ->where('is_active', true)
            ->withCount([
                'projects' => fn ($query) => $query
                    ->where('is_published', true),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $projects = Project::query()
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

        return view('frontend.pages.projects.index', compact(
            'page',
            'sections',
            'categories',
            'projects',
            'categorySlug'
        ));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $project->increment('views');

        $project->load('category');

        $relatedProjects = Project::query()
            ->with('category')
            ->where('is_published', true)
            ->whereKeyNot($project->getKey())
            ->when(
                $project->project_category_id,
                fn ($query) => $query->where(
                    'project_category_id',
                    $project->project_category_id
                )
            )
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->limit(3)
            ->get();

        return view('frontend.pages.projects.show', compact(
            'project',
            'relatedProjects'
        ));
    }
}
