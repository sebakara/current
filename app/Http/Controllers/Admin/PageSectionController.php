<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use JsonException;

class PageSectionController extends Controller
{
    public function index(Page $page): View
    {
        $sections = $page->sections()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view(
            'admin.page-sections.index',
            compact('page', 'sections')
        );
    }

    public function create(Page $page): View
    {
        return view(
            'admin.page-sections.create',
            compact('page')
        );
    }

    public function store(
        Request $request,
        Page $page
    ): RedirectResponse {
        $validated = $this->validateSection(
            $request,
            $page
        );

        $validated = $this->prepareData(
            $request,
            $validated
        );

        $validated['page_id'] = $page->id;

        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store(
                    "pages/{$page->slug}/sections",
                    'public'
                );
        }

        PageSection::create($validated);

        return redirect()
            ->route(
                'admin.pages.sections.index',
                $page
            )
            ->with(
                'success',
                'Page section created successfully.'
            );
    }

    public function edit(
        Page $page,
        PageSection $section
    ): View {
        $this->ensureSectionBelongsToPage(
            $page,
            $section
        );

        return view(
            'admin.page-sections.edit',
            compact('page', 'section')
        );
    }

    public function update(
        Request $request,
        Page $page,
        PageSection $section
    ): RedirectResponse {
        $this->ensureSectionBelongsToPage(
            $page,
            $section
        );

        $validated = $this->validateSection(
            $request,
            $page,
            $section
        );

        $validated = $this->prepareData(
            $request,
            $validated
        );

        if ($request->boolean('remove_image')) {
            $this->deleteImage($section->image);
            $validated['image'] = null;
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($section->image);

            $validated['image'] = $request
                ->file('image')
                ->store(
                    "pages/{$page->slug}/sections",
                    'public'
                );
        }

        unset($validated['remove_image']);

        $section->update($validated);

        return redirect()
            ->route(
                'admin.pages.sections.index',
                $page
            )
            ->with(
                'success',
                'Page section updated successfully.'
            );
    }

    public function destroy(
        Page $page,
        PageSection $section
    ): RedirectResponse {
        $this->ensureSectionBelongsToPage(
            $page,
            $section
        );

        $this->deleteImage($section->image);

        $section->delete();

        return redirect()
            ->route(
                'admin.pages.sections.index',
                $page
            )
            ->with(
                'success',
                'Page section deleted successfully.'
            );
    }

    private function validateSection(
        Request $request,
        Page $page,
        ?PageSection $section = null
    ): array {
        return $request->validate([
            'section_key' => [
                'required',
                'string',
                'max:150',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique(
                    'page_sections',
                    'section_key'
                )
                    ->where(
                        fn ($query) => $query->where(
                            'page_id',
                            $page->id
                        )
                    )
                    ->ignore($section?->id),
            ],
            'title' => [
                'nullable',
                'string',
                'max:500',
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
            'layout' => [
                'nullable',
                'string',
                'max:100',
            ],
            'data_json' => [
                'nullable',
                'string',
                'max:100000',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'remove_image' => [
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

    private function prepareData(
        Request $request,
        array $validated
    ): array {
        $validated['section_key'] = Str::lower(
            trim($validated['section_key'])
        );

        $validated['data'] = $this->parseJson(
            $request->input('data_json')
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        unset(
            $validated['data_json'],
            $validated['remove_image']
        );

        return $validated;
    }

    private function parseJson(?string $json): ?array
    {
        $json = trim((string) $json);

        if ($json === '') {
            return null;
        }

        try {
            $decoded = json_decode(
                $json,
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            throw ValidationException::withMessages([
                'data_json' =>
                    'The structured data contains invalid JSON: '
                    . $exception->getMessage(),
            ]);
        }

        if (! is_array($decoded)) {
            throw ValidationException::withMessages([
                'data_json' =>
                    'The structured data must be a JSON object or array.',
            ]);
        }

        return $decoded;
    }

    private function ensureSectionBelongsToPage(
        Page $page,
        PageSection $section
    ): void {
        abort_unless(
            $section->page_id === $page->id,
            404
        );
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
