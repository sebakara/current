<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class HeroSlideController extends Controller
{
    public function index(): View
    {
        $slides = HeroSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.hero-slides.index', compact('slides'));
    }

    public function create(): View
    {
        return view('admin.hero-slides.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSlide($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->hasFile('background_image')) {
            $validated['background_image'] = $request
                ->file('background_image')
                ->store('hero-slides/desktop', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image'] = $request
                ->file('mobile_image')
                ->store('hero-slides/mobile', 'public');
        }

        HeroSlide::create($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide created successfully.');
    }

    public function show(HeroSlide $heroSlide): View
    {
        return view(
            'admin.hero-slides.show',
            compact('heroSlide')
        );
    }

    public function edit(HeroSlide $heroSlide): View
    {
        return view(
            'admin.hero-slides.edit',
            compact('heroSlide')
        );
    }

    public function update(
        Request $request,
        HeroSlide $heroSlide
    ): RedirectResponse {
        $validated = $this->validateSlide($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->boolean('remove_background_image')) {
            $this->deleteImage($heroSlide->background_image);
            $validated['background_image'] = null;
        }

        if ($request->hasFile('background_image')) {
            $this->deleteImage($heroSlide->background_image);

            $validated['background_image'] = $request
                ->file('background_image')
                ->store('hero-slides/desktop', 'public');
        }

        if ($request->boolean('remove_mobile_image')) {
            $this->deleteImage($heroSlide->mobile_image);
            $validated['mobile_image'] = null;
        }

        if ($request->hasFile('mobile_image')) {
            $this->deleteImage($heroSlide->mobile_image);

            $validated['mobile_image'] = $request
                ->file('mobile_image')
                ->store('hero-slides/mobile', 'public');
        }

        unset(
            $validated['remove_background_image'],
            $validated['remove_mobile_image']
        );

        $heroSlide->update($validated);

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(
        HeroSlide $heroSlide
    ): RedirectResponse {
        $this->deleteImage($heroSlide->background_image);
        $this->deleteImage($heroSlide->mobile_image);

        $heroSlide->delete();

        return redirect()
            ->route('admin.hero-slides.index')
            ->with('success', 'Hero slide deleted successfully.');
    }

    private function validateSlide(Request $request): array
    {
        return $request->validate([
            'eyebrow' => [
                'nullable',
                'string',
                'max:150',
            ],
            'title' => [
                'required',
                'string',
                'max:500',
            ],
            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
            'background_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:12288',
            ],
            'mobile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'primary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],
            'primary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'secondary_button_text' => [
                'nullable',
                'string',
                'max:100',
            ],
            'secondary_button_url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'text_position' => [
                'required',
                Rule::in([
                    'left',
                    'center',
                    'right',
                ]),
            ],
            'remove_background_image' => [
                'nullable',
                'boolean',
            ],
            'remove_mobile_image' => [
                'nullable',
                'boolean',
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
