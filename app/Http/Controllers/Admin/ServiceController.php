<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $categoryId = $request->input('category');
        $status = $request->input('status');

        $services = Service::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere(
                            'short_description',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->when($categoryId, function ($query) use ($categoryId) {
                $query->where(
                    'service_category_id',
                    $categoryId
                );
            })
            ->when($status === 'published', function ($query) {
                $query->where('is_published', true);
            })
            ->when($status === 'draft', function ($query) {
                $query->where('is_published', false);
            })
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.services.index', compact(
            'services',
            'categories',
            'search',
            'categoryId',
            'status'
        ));
    }

    public function create(): View
    {
        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.services.create', compact('categories'));
    }

    public function store(ServiceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['slug'] ?? $data['title']
        );

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request
                ->file('featured_image')
                ->store('services/featured', 'public');
        }

        if ($request->hasFile('gallery')) {
            $data['gallery'] = collect(
                $request->file('gallery')
            )->map(function ($image) {
                return $image->store(
                    'services/gallery',
                    'public'
                );
            })->values()->all();
        }

        Service::create($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function show(Service $service): View
    {
        $service->load('category');

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        $categories = ServiceCategory::query()
            ->where('is_active', true)
            ->orWhere('id', $service->service_category_id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.services.edit', compact(
            'service',
            'categories'
        ));
    }

    public function update(
        ServiceRequest $request,
        Service $service
    ): RedirectResponse {
        $data = $request->validated();

        $data['slug'] = $this->generateUniqueSlug(
            $data['slug'] ?? $data['title'],
            $service->id
        );

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($request->hasFile('featured_image')) {
            if ($service->featured_image) {
                Storage::disk('public')->delete(
                    $service->featured_image
                );
            }

            $data['featured_image'] = $request
                ->file('featured_image')
                ->store('services/featured', 'public');
        }

        if ($request->hasFile('gallery')) {
            foreach ($service->gallery ?? [] as $image) {
                Storage::disk('public')->delete($image);
            }

            $data['gallery'] = collect(
                $request->file('gallery')
            )->map(function ($image) {
                return $image->store(
                    'services/gallery',
                    'public'
                );
            })->values()->all();
        }

        $service->update($data);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->featured_image) {
            Storage::disk('public')->delete(
                $service->featured_image
            );
        }

        foreach ($service->gallery ?? [] as $image) {
            Storage::disk('public')->delete($image);
        }

        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    public function togglePublish(Service $service): RedirectResponse
    {
        $service->update([
            'is_published' => !$service->is_published,
        ]);

        return back()->with(
            'success',
            'Service publication status updated.'
        );
    }

    public function toggleFeatured(Service $service): RedirectResponse
    {
        $service->update([
            'is_featured' => !$service->is_featured,
        ]);

        return back()->with(
            'success',
            'Service featured status updated.'
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
            Service::query()
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
