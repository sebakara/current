<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FooterSectionController extends Controller
{
    public function index(): View
    {
        $sections = FooterSection::query()
            ->withCount('links')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view(
            'admin.footer-sections.index',
            compact('sections')
        );
    }

    public function create(): View
    {
        return view('admin.footer-sections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateSection($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $section = FooterSection::create($validated);

        return redirect()
            ->route('admin.footer-sections.show', $section)
            ->with(
                'success',
                'Footer section created successfully.'
            );
    }

    public function show(
        FooterSection $footerSection
    ): View {
        $footerSection->load([
            'links' => fn ($query) => $query
                ->withoutGlobalScopes()
                ->orderBy('sort_order')
                ->orderBy('label'),
        ]);

        return view(
            'admin.footer-sections.show',
            compact('footerSection')
        );
    }

    public function edit(
        FooterSection $footerSection
    ): View {
        return view(
            'admin.footer-sections.edit',
            compact('footerSection')
        );
    }

    public function update(
        Request $request,
        FooterSection $footerSection
    ): RedirectResponse {
        $validated = $this->validateSection(
            $request,
            $footerSection
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $footerSection->update($validated);

        return redirect()
            ->route(
                'admin.footer-sections.show',
                $footerSection
            )
            ->with(
                'success',
                'Footer section updated successfully.'
            );
    }

    public function destroy(
        FooterSection $footerSection
    ): RedirectResponse {
        if ($footerSection->links()->exists()) {
            return back()->with(
                'error',
                'Remove all links before deleting this footer section.'
            );
        }

        $footerSection->delete();

        return redirect()
            ->route('admin.footer-sections.index')
            ->with(
                'success',
                'Footer section deleted successfully.'
            );
    }

    private function validateSection(
        Request $request,
        ?FooterSection $footerSection = null
    ): array {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:150',
            ],
            'section_key' => [
                'required',
                'string',
                'max:100',
                'regex:/^[a-z0-9_-]+$/',
                Rule::unique(
                    'footer_sections',
                    'section_key'
                )->ignore($footerSection?->id),
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
                'max:100000',
            ],
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);
    }
}
