<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $categories = ProjectCategory::query()
            ->withCount('projects')
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

        return view('admin.project-categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create(): View
    {
        return view('admin.project-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        ProjectCategory::create($validated);

        return redirect()
            ->route('admin.project-categories.index')
            ->with(
                'success',
                'Project category created successfully.'
            );
    }

    public function show(
        ProjectCategory $projectCategory
    ): View {
        $projectCategory->loadCount('projects');

        $projects = $projectCategory
            ->projects()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(10)
            ->get();

        return view(
            'admin.project-categories.show',
            compact('projectCategory', 'projects')
        );
    }

    public function edit(
        ProjectCategory $projectCategory
    ): View {
        return view(
            'admin.project-categories.edit',
            compact('projectCategory')
        );
    }

    public function update(
        Request $request,
        ProjectCategory $projectCategory
    ): RedirectResponse {
        $validated = $this->validateCategory(
            $request,
            $projectCategory
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $projectCategory->id
        );

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $projectCategory->update($validated);

        return redirect()
            ->route('admin.project-categories.index')
            ->with(
                'success',
                'Project category updated successfully.'
            );
    }

    public function destroy(
        ProjectCategory $projectCategory
    ): RedirectResponse {
        if ($projectCategory->projects()->exists()) {
            return back()->with(
                'error',
                'This category contains projects. Move or delete those projects before deleting the category.'
            );
        }

        $projectCategory->delete();

        return redirect()
            ->route('admin.project-categories.index')
            ->with(
                'success',
                'Project category deleted successfully.'
            );
    }

    private function validateCategory(
        Request $request,
        ?ProjectCategory $projectCategory = null
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
                Rule::unique('project_categories', 'slug')
                    ->ignore($projectCategory?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
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
        $baseSlug = Str::slug($value) ?: 'project-category';
        $slug = $baseSlug;
        $counter = 2;

        while (
            ProjectCategory::query()
                ->withTrashed()
                ->when(
                    $ignoreId,
                    fn ($query) => $query->whereKeyNot($ignoreId)
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
