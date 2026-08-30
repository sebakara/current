<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use App\Models\FooterSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FooterLinkController extends Controller
{
    public function create(
        FooterSection $footerSection
    ): View {
        $routeNames = $this->routeNames();

        return view(
            'admin.footer-links.create',
            compact(
                'footerSection',
                'routeNames'
            )
        );
    }

    public function store(
        Request $request,
        FooterSection $footerSection
    ): RedirectResponse {
        $validated = $this->validateLink($request);

        $validated['footer_section_id'] =
            $footerSection->id;

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated = $this->cleanLinkFields($validated);

        FooterLink::create($validated);

        return redirect()
            ->route(
                'admin.footer-sections.show',
                $footerSection
            )
            ->with(
                'success',
                'Footer link created successfully.'
            );
    }

    public function edit(
        FooterSection $footerSection,
        FooterLink $footerLink
    ): View {
        $this->ensureLinkBelongsToSection(
            $footerSection,
            $footerLink
        );

        $routeNames = $this->routeNames();

        return view(
            'admin.footer-links.edit',
            compact(
                'footerSection',
                'footerLink',
                'routeNames'
            )
        );
    }

    public function update(
        Request $request,
        FooterSection $footerSection,
        FooterLink $footerLink
    ): RedirectResponse {
        $this->ensureLinkBelongsToSection(
            $footerSection,
            $footerLink
        );

        $validated = $this->validateLink($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $validated = $this->cleanLinkFields($validated);

        $footerLink->update($validated);

        return redirect()
            ->route(
                'admin.footer-sections.show',
                $footerSection
            )
            ->with(
                'success',
                'Footer link updated successfully.'
            );
    }

    public function destroy(
        FooterSection $footerSection,
        FooterLink $footerLink
    ): RedirectResponse {
        $this->ensureLinkBelongsToSection(
            $footerSection,
            $footerLink
        );

        $footerLink->delete();

        return redirect()
            ->route(
                'admin.footer-sections.show',
                $footerSection
            )
            ->with(
                'success',
                'Footer link deleted successfully.'
            );
    }

    private function validateLink(
        Request $request
    ): array {
        return $request->validate([
            'label' => [
                'required',
                'string',
                'max:150',
            ],
            'url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'route_name' => [
                'nullable',
                'string',
                'max:200',
            ],
            'target' => [
                'required',
                Rule::in([
                    '_self',
                    '_blank',
                ]),
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

    private function cleanLinkFields(array $validated): array
    {
        $validated['url'] = trim(
            (string) ($validated['url'] ?? '')
        ) ?: null;

        $validated['route_name'] = trim(
            (string) ($validated['route_name'] ?? '')
        ) ?: null;

        if ($validated['route_name']) {
            $validated['url'] = null;
        }

        return $validated;
    }

    private function routeNames(): array
    {
        return collect(Route::getRoutes())
            ->map(fn ($route) => $route->getName())
            ->filter()
            ->reject(
                fn ($name) => str_starts_with(
                    $name,
                    'admin.'
                )
            )
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function ensureLinkBelongsToSection(
        FooterSection $footerSection,
        FooterLink $footerLink
    ): void {
        abort_unless(
            $footerLink->footer_section_id
                === $footerSection->id,
            404
        );
    }
}
