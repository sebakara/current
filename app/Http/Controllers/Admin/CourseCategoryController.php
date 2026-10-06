<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));

        $categories = CourseCategory::query()
            ->withCount('courses')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhere('icon', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        return view('admin.course-categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create(): View
    {
        return view('admin.course-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCategory($request);

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name']
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] =
            (int) ($validated['sort_order'] ?? 0);

        CourseCategory::create($validated);

        return redirect()
            ->route('admin.course-categories.index')
            ->with(
                'success',
                'Course category created successfully.'
            );
    }

    public function show(
        CourseCategory $courseCategory
    ): View {
        $courseCategory->loadCount('courses');

        $courses = $courseCategory
            ->courses()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->limit(10)
            ->get();

        return view(
            'admin.course-categories.show',
            compact('courseCategory', 'courses')
        );
    }

    public function edit(
        CourseCategory $courseCategory
    ): View {
        return view(
            'admin.course-categories.edit',
            compact('courseCategory')
        );
    }

    public function update(
        Request $request,
        CourseCategory $courseCategory
    ): RedirectResponse {
        $validated = $this->validateCategory(
            $request,
            $courseCategory
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['name'],
            $courseCategory->id
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] =
            (int) ($validated['sort_order'] ?? 0);

        $courseCategory->update($validated);

        return redirect()
            ->route('admin.course-categories.index')
            ->with(
                'success',
                'Course category updated successfully.'
            );
    }

    public function destroy(
        CourseCategory $courseCategory
    ): RedirectResponse {
        if ($courseCategory->courses()->exists()) {
            return back()->with(
                'error',
                'This category contains courses. Move or delete those courses before deleting the category.'
            );
        }

        $courseCategory->delete();

        return redirect()
            ->route('admin.course-categories.index')
            ->with(
                'success',
                'Course category deleted successfully.'
            );
    }

    private function validateCategory(
        Request $request,
        ?CourseCategory $courseCategory = null
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
                Rule::unique('course_categories', 'slug')
                    ->ignore($courseCategory?->id),
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:100',
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
        $baseSlug = Str::slug($value) ?: 'course-category';
        $slug = $baseSlug;
        $counter = 2;

        while (
            CourseCategory::query()
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
