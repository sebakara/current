<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $categoryId = $request->integer('category');
        $status = (string) $request->query('status', 'all');

        $courses = Course::query()
            ->with('category')
            ->withCount('applications')
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%");
                });
            })
            ->when(
                $categoryId > 0,
                fn (Builder $query) => $query->where(
                    'course_category_id',
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
            ->when(
                $status === 'open',
                fn (Builder $query) => $query->where('applications_open', true)
            )
            ->when(
                $status === 'closed',
                fn (Builder $query) => $query->where('applications_open', false)
            )
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $categories = CourseCategory::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.courses.index', compact(
            'courses',
            'categories',
            'search',
            'categoryId',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.courses.create', [
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateCourse($request);

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
                ->store('courses/featured', 'public');
        }

        if ($request->hasFile('gallery_images')) {
            $validated['gallery'] = collect(
                $request->file('gallery_images')
            )
                ->map(
                    fn ($image) => $image->store(
                        'courses/gallery',
                        'public'
                    )
                )
                ->values()
                ->all();
        }

        Course::create($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course created successfully.');
    }

    public function show(Course $course): View
    {
        $course->load('category');
        $course->loadCount('applications');

        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course): View
    {
        $course->load('category');

        return view('admin.courses.edit', [
            'course' => $course,
            'categories' => $this->categories(),
        ]);
    }

    public function update(
        Request $request,
        Course $course
    ): RedirectResponse {
        $validated = $this->validateCourse(
            $request,
            $course
        );

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['slug'] = $this->uniqueSlug(
            $validated['slug'] ?: $validated['title'],
            $course->id
        );

        if ($request->boolean('remove_featured_image')) {
            $this->deletePublicFile($course->featured_image);
            $validated['featured_image'] = null;
        }

        if ($request->hasFile('featured_image')) {
            $this->deletePublicFile($course->featured_image);

            $validated['featured_image'] = $request
                ->file('featured_image')
                ->store('courses/featured', 'public');
        }

        $gallery = collect($course->gallery ?? []);

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
                    'courses/gallery',
                    'public'
                )
            );

            $gallery = $gallery->merge($newImages);
        }

        $validated['gallery'] = $gallery
            ->filter()
            ->values()
            ->all();

        $course->update($validated);

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        if ($course->applications()->exists()) {
            return back()->with(
                'error',
                'This course already has applications. Unpublish it instead of deleting it.'
            );
        }

        $course->delete();

        return redirect()
            ->route('admin.courses.index')
            ->with('success', 'Course deleted successfully.');
    }

    private function validateCourse(
        Request $request,
        ?Course $course = null
    ): array {
        return $request->validate([
            'course_category_id' => [
                'required',
                'integer',
                Rule::exists('course_categories', 'id')
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
                Rule::unique('courses', 'slug')
                    ->ignore($course?->id),
            ],
            'code' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('courses', 'code')
                    ->ignore($course?->id),
            ],
            'short_description' => [
                'nullable',
                'string',
                'max:600',
            ],
            'overview' => [
                'nullable',
                'string',
                'max:30000',
            ],
            'description' => [
                'nullable',
                'string',
                'max:30000',
            ],
            'requirements' => [
                'nullable',
                'string',
                'max:15000',
            ],
            'learning_outcomes' => [
                'nullable',
                'string',
                'max:15000',
            ],
            'outcomes' => [
                'nullable',
                'string',
                'max:15000',
            ],
            'duration' => [
                'nullable',
                'string',
                'max:150',
            ],
            'schedule' => [
                'nullable',
                'string',
                'max:500',
            ],
            'delivery_mode' => [
                'nullable',
                'string',
                'max:100',
            ],
            'location' => [
                'nullable',
                'string',
                'max:200',
            ],
            'fee' => [
                'nullable',
                'numeric',
                'min:0',
                'max:999999999999',
            ],
            'currency' => [
                'required',
                'string',
                'max:10',
            ],
            'application_deadline' => [
                'nullable',
                'date',
            ],
            'starts_at' => [
                'nullable',
                'date',
            ],
            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],
            'start_date' => [
                'nullable',
                'date',
            ],
            'available_places' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000',
            ],
            'max_students' => [
                'nullable',
                'integer',
                'min:1',
                'max:100000',
            ],
            'modules_text' => [
                'nullable',
                'string',
                'max:20000',
            ],
            'curriculum_text' => [
                'nullable',
                'string',
                'max:20000',
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
            'applications_open' => [
                'nullable',
                'boolean',
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
        $validated['modules'] = $this->parseLines(
            $request->input('modules_text')
        );

        $validated['curriculum'] = $this->parseLines(
            $request->input('curriculum_text')
        );

        $validated['applications_open'] =
            $request->boolean('applications_open');

        $validated['is_featured'] =
            $request->boolean('is_featured');

        $validated['is_published'] =
            $request->boolean('is_published');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated['currency'] = Str::upper(
            trim($validated['currency'] ?: 'RWF')
        );

        $validated['available_places'] =
            isset($validated['available_places'])
            && $validated['available_places'] !== null
                ? (int) $validated['available_places']
                : null;

        $validated['max_students'] =
            isset($validated['max_students'])
            && $validated['max_students'] !== null
                ? (int) $validated['max_students']
                : null;

        unset(
            $validated['modules_text'],
            $validated['curriculum_text'],
            $validated['remove_featured_image'],
            $validated['remove_gallery_images'],
            $validated['remove_all_gallery_images']
        );

        return $validated;
    }

    private function parseLines(?string $value): array
    {
        return collect(
            preg_split('/\r\n|\r|\n/', $value ?? '')
        )
            ->map(fn ($line) => trim($line))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function categories()
    {
        return CourseCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    private function uniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: 'course';
        $slug = $baseSlug;
        $counter = 2;

        while (
            Course::query()
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
