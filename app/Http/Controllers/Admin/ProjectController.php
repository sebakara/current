<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->integer('category');
        $status = (string) $request->query('status', 'all');

        $projects = Project::query()
            ->with('category')
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when(
                $categoryId > 0,
                fn (Builder $query) => $query->where(
                    'project_category_id',
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
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $categories = ProjectCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.projects.index', compact(
            'projects',
            'categories',
            'search',
            'categoryId',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.projects.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProject($request);

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['title']
        );

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('projects/featured', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $validated['gallery'] = collect(
                $request->file('gallery_images')
            )
                ->map(
                    fn ($image) => $image->store(
                        'projects/gallery',
                        'public'
                    )
                )
                ->values()
                ->all();
        }

        Project::create($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project): View
    {
        $project->load('category');

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $project->load('category');

        return view('admin.projects.edit', [
            'project' => $project,
            'categories' => $this->categories(),
        ]);
    }

    public function update(
        Request $request,
        Project $project
    ): RedirectResponse {
        $validated = $this->validateProject(
            $request,
            $project
        );

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['title'],
            $project->id
        );

        if ($request->boolean('remove_featured_image')) {
            $this->deletePublicFile($project->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $this->deletePublicFile($project->featured_image);

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('projects/featured', 'public');
        }

        $gallery = collect($project->gallery ?? []);

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
                    'projects/gallery',
                    'public'
                )
            );

            $gallery = $gallery->merge($newImages);
        }

        $validated['gallery'] = $gallery
            ->filter()
            ->values()
            ->all();

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    private function validateProject(
        Request $request,
        ?Project $project = null
    ): array {
        return $request->validate([
            'project_category_id' => [
                'required',
                'integer',
                Rule::exists('project_categories', 'id')
                    ->whereNull('deleted_at'),
            ],
            'title' => [
                'required',
                'string',
                'max:200',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:220',
                Rule::unique('projects', 'slug')
                    ->ignore($project?->id),
            ],
            'client_name' => [
                'nullable',
                'string',
                'max:180',
            ],
            'location' => [
                'nullable',
                'string',
                'max:180',
            ],
            'completed_at' => [
                'nullable',
                'date',
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:600',
            ],
            'description' => [
                'nullable',
                'string',
                'max:30000',
            ],
            'challenge' => [
                'nullable',
                'string',
                'max:20000',
            ],
            'solution' => [
                'nullable',
                'string',
                'max:20000',
            ],
            'technologies_text' => [
                'nullable',
                'string',
                'max:10000',
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
            'is_featured' => [
                'nullable',
                'boolean',
            ],
            'is_published' => [
                'nullable',
                'boolean',
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
        ]);
    }

    private function prepareData(
        Request $request,
        array $validated
    ): array {
        $validated['technologies'] = collect(
            preg_split(
                '/\r\n|\r|\n|,/',
                $request->input('technologies_text', '')
            )
        )
            ->map(fn ($technology) => trim($technology))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $validated['is_featured'] =
            $request->boolean('is_featured');

        $validated['is_published'] =
            $request->boolean('is_published');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        unset(
            $validated['technologies_text'],
            $validated['remove_featured_image'],
            $validated['remove_gallery_images'],
            $validated['remove_all_gallery_images']
        );

        return $validated;
    }

    private function categories()
    {
        return ProjectCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'project';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Project::query()
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
