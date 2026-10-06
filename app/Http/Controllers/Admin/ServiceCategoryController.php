<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceCategoryRequest;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $categories = ServiceCategory::query()
            ->withCount('services')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.service-categories.index', compact(
            'categories',
            'search'
        ));
    }

    public function create(): View
    {
        return view('admin.service-categories.create');
    }

    public function store(
        ServiceCategoryRequest $request
    ): RedirectResponse {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['slug'] ?? $data['name']
        );

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('service-categories', 'public');
        }

        ServiceCategory::create($data);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Service category created successfully.');
    }

    public function show(ServiceCategory $serviceCategory): View
    {
        $serviceCategory->loadCount('services');

        return view(
            'admin.service-categories.show',
            compact('serviceCategory')
        );
    }

    public function edit(
        ServiceCategory $serviceCategory
    ): View {
        return view(
            'admin.service-categories.edit',
            compact('serviceCategory')
        );
    }

    public function update(
        ServiceCategoryRequest $request,
        ServiceCategory $serviceCategory
    ): RedirectResponse {
        $data = $request->validated();

        $requestedSlug = $data['slug'] ?? $data['name'];

        $data['slug'] = $this->generateUniqueSlug(
            $requestedSlug,
            $serviceCategory->id
        );

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('image')) {
            if ($serviceCategory->image) {
                Storage::disk('public')->delete(
                    $serviceCategory->image
                );
            }

            $data['image'] = $request->file('image')
                ->store('service-categories', 'public');
        }

        $serviceCategory->update($data);

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Service category updated successfully.');
    }

    public function destroy(
        ServiceCategory $serviceCategory
    ): RedirectResponse {
        if ($serviceCategory->services()->exists()) {
            return back()->with(
                'error',
                'This category cannot be deleted because it contains services.'
            );
        }

        if ($serviceCategory->image) {
            Storage::disk('public')->delete(
                $serviceCategory->image
            );
        }

        $serviceCategory->delete();

        return redirect()
            ->route('admin.service-categories.index')
            ->with('success', 'Service category deleted successfully.');
    }

    public function toggleStatus(
        ServiceCategory $serviceCategory
    ): RedirectResponse {
        $serviceCategory->update([
            'is_active' => !$serviceCategory->is_active,
        ]);

        return back()->with(
            'success',
            'Category status updated successfully.'
        );
    }

    private function generateUniqueSlug(
        string $value,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($value) ?: Str::random(8);
        $slug = $baseSlug;
        $counter = 1;

        while (
            ServiceCategory::query()
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
