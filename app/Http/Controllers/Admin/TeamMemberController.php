<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TeamMemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');
        $department = trim(
            (string) $request->query('department')
        );

        $members = TeamMember::query()
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhere('department', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when(
                $status === 'active',
                fn (Builder $query) => $query->where(
                    'is_active',
                    true
                )
            )
            ->when(
                $status === 'inactive',
                fn (Builder $query) => $query->where(
                    'is_active',
                    false
                )
            )
            ->when(
                $department !== '',
                fn (Builder $query) => $query->where(
                    'department',
                    $department
                )
            )
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20)
            ->withQueryString();

        $departments = TeamMember::query()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('admin.team-members.index', compact(
            'members',
            'departments',
            'search',
            'status',
            'department'
        ));
    }

    public function create(): View
    {
        return view('admin.team-members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMember($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request
                ->file('photo')
                ->store('team-members', 'public');
        }

        TeamMember::create($validated);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member created successfully.');
    }

    public function show(TeamMember $teamMember): View
    {
        return view(
            'admin.team-members.show',
            compact('teamMember')
        );
    }

    public function edit(TeamMember $teamMember): View
    {
        return view(
            'admin.team-members.edit',
            compact('teamMember')
        );
    }

    public function update(
        Request $request,
        TeamMember $teamMember
    ): RedirectResponse {
        $validated = $this->validateMember(
            $request,
            $teamMember
        );

        $validated['is_active'] =
            $request->boolean('is_active');

        $validated['sort_order'] = (int) (
            $validated['sort_order'] ?? 0
        );

        if ($request->boolean('remove_photo')) {
            $this->deletePhoto($teamMember->photo);
            $validated['photo'] = null;
        }

        if ($request->hasFile('photo')) {
            $this->deletePhoto($teamMember->photo);

            $validated['photo'] = $request
                ->file('photo')
                ->store('team-members', 'public');
        }

        unset($validated['remove_photo']);

        $teamMember->update($validated);

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member updated successfully.');
    }

    public function destroy(
        TeamMember $teamMember
    ): RedirectResponse {
        $this->deletePhoto($teamMember->photo);

        $teamMember->delete();

        return redirect()
            ->route('admin.team-members.index')
            ->with('success', 'Team member deleted successfully.');
    }

    private function validateMember(
        Request $request,
        ?TeamMember $teamMember = null
    ): array {
        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],
            'role' => [
                'required',
                'string',
                'max:150',
            ],
            'department' => [
                'nullable',
                'string',
                'max:150',
            ],
            'bio' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:8192',
            ],
            'remove_photo' => [
                'nullable',
                'boolean',
            ],
            'email' => [
                'nullable',
                'email',
                'max:150',
                Rule::unique('team_members', 'email')
                    ->ignore($teamMember?->id),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:50',
            ],
            'linkedin_url' => [
                'nullable',
                'url',
                'max:500',
            ],
            'twitter_url' => [
                'nullable',
                'url',
                'max:500',
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

    private function deletePhoto(?string $path): void
    {
        if (
            $path
            && Storage::disk('public')->exists($path)
        ) {
            Storage::disk('public')->delete($path);
        }
    }
}
