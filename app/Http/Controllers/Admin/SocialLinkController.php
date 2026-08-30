<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SocialLinkController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');

        $links = SocialLink::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('platform', 'like', "%{$search}%")
                        ->orWhere('url', 'like', "%{$search}%")
                        ->orWhere('icon', 'like', "%{$search}%");
                });
            })
            ->when(
                $status === 'active',
                fn (Builder $query) => $query->where('is_active', true)
            )
            ->when(
                $status === 'inactive',
                fn (Builder $query) => $query->where('is_active', false)
            )
            ->orderBy('sort_order')
            ->orderBy('platform')
            ->paginate(20)
            ->withQueryString();

        return view('admin.social-links.index', compact(
            'links',
            'search',
            'status'
        ));
    }

    public function create(): View
    {
        return view('admin.social-links.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateLink($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        SocialLink::create($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link created successfully.');
    }

    public function show(SocialLink $socialLink): View
    {
        return view(
            'admin.social-links.show',
            compact('socialLink')
        );
    }

    public function edit(SocialLink $socialLink): View
    {
        return view(
            'admin.social-links.edit',
            compact('socialLink')
        );
    }

    public function update(
        Request $request,
        SocialLink $socialLink
    ): RedirectResponse {
        $validated = $this->validateLink(
            $request,
            $socialLink
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        $socialLink->update($validated);

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link updated successfully.');
    }

    public function destroy(
        SocialLink $socialLink
    ): RedirectResponse {
        $socialLink->delete();

        return redirect()
            ->route('admin.social-links.index')
            ->with('success', 'Social link deleted successfully.');
    }

    private function validateLink(
        Request $request,
        ?SocialLink $socialLink = null
    ): array {
        return $request->validate([
            'platform' => [
                'required',
                'string',
                'max:100',
                Rule::unique('social_links', 'platform')
                    ->ignore($socialLink?->id),
            ],
            'url' => [
                'required',
                'url',
                'max:500',
            ],
            'icon' => [
                'nullable',
                'string',
                'max:200',
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
