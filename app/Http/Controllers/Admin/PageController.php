<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');

        $pages = Page::query()
            ->withCount([
                'sections',
                'activeSections',
            ])
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('subtitle', 'like', "%{$search}%")
                        ->orWhere('template', 'like', "%{$search}%");
                });
            })
            ->when(
                $status === 'published',
                fn (Builder $query) => $query->where(
                    'is_published',
                    true
                )
            )
            ->when(
                $status === 'draft',
                fn (Builder $query) => $query->where(
                    'is_published',
                    false
                )
            )
            ->orderBy('sort_order')
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        return view('admin.pages.index', compact(
            'pages',
            'search',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.pages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePage($request);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['title']
        );

        $validated['is_published'] =
            $request->boolean('is_published');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('pages/featured', 'public');
        }

        $page = Page::create($validated);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page created successfully.');
    }

    public function show(Page $page): View
    {
        $page->load('sections');

        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(
        Request $request,
        Page $page
    ): RedirectResponse {
        $validated = $this->validatePage(
            $request,
            $page
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['title'],
            $page->id
        );

        $validated['is_published'] =
            $request->boolean('is_published');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->boolean('remove_featured_image')) {
            $this->deleteImage($page->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($page->featured_image);

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('pages/featured', 'public');
        }

        unset($validated['remove_featured_image']);

        $page->update($validated);

        return redirect()
            ->route('admin.pages.show', $page)
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->sections()->exists()) {
            return back()->with(
                'error',
                'This page contains sections. Remove its sections before deleting it.'
            );
        }

        $this->deleteImage($page->featured_image);

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    private function validatePage(
        Request $request,
        ?Page $page = null
    ): array {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:200',
            ],
            'slug' => [
                'nullable',
                'string',
                'max:220',
                Rule::unique('pages', 'slug')
                    ->ignore($page?->id),
            ],
            'subtitle' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'content' => [
                'nullable',
                'string',
                'max:50000',
            ],
            'template' => [
                'nullable',
                'string',
                'max:100',
            ],
            'featured_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'remove_featured_image' => [
                'nullable',
                'boolean',
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
        ]);
    }

    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'page';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Page::query()
                ->withTrashed()
                ->when(
                    $ignoreId,
                    fn (Builder $query) => $query->whereKeyNot(
                        $ignoreId
                    )
                )
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }

    private function deleteImage(?string $path): void
    {
        if (
            $path
            && Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}
