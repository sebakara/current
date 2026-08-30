<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(Request $request): View
    {
        $status = (string) $request->query('status', 'all');
        $type = (string) $request->query('type', 'all');

        $announcements = Announcement::query()
            ->when(
                $status === 'active',
                fn ($query) => $query->currentlyActive()
            )
            ->when(
                $status === 'inactive',
                fn ($query) => $query->where('is_active', false)
            )
            ->when(
                $status === 'scheduled',
                fn ($query) => $query
                    ->where('is_active', true)
                    ->whereNotNull('starts_at')
                    ->where('starts_at', '>', now())
            )
            ->when(
                $status === 'expired',
                fn ($query) => $query
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '<', now())
            )
            ->when(
                $type !== 'all',
                fn ($query) => $query->where('type', $type)
            )
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.announcements.index',
            compact(
                'announcements',
                'status',
                'type'
            )
        );
    }

    public function create(): View
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateAnnouncement($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        Announcement::create($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement created successfully.'
            );
    }

    public function show(
        Announcement $announcement
    ): View {
        return view(
            'admin.announcements.show',
            compact('announcement')
        );
    }

    public function edit(
        Announcement $announcement
    ): View {
        return view(
            'admin.announcements.edit',
            compact('announcement')
        );
    }

    public function update(
        Request $request,
        Announcement $announcement
    ): RedirectResponse {
        $validated = $this->validateAnnouncement($request);

        $validated['is_active'] =
            $request->boolean('is_active');

        $announcement->update($validated);

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement updated successfully.'
            );
    }

    public function destroy(
        Announcement $announcement
    ): RedirectResponse {
        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with(
                'success',
                'Announcement deleted successfully.'
            );
    }

    private function validateAnnouncement(
        Request $request
    ): array {
        return $request->validate([
            'title' => [
                'required',
                'string',
                'max:200',
            ],
            'message' => [
                'required',
                'string',
                'max:3000',
            ],
            'button_text' => [
                'nullable',
                'string',
                'max:100',
            ],
            'button_url' => [
                'nullable',
                'string',
                'max:500',
            ],
            'type' => [
                'required',
                Rule::in([
                    'info',
                    'success',
                    'warning',
                    'danger',
                    'promotion',
                ]),
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
            'is_active' => [
                'nullable',
                'boolean',
            ],
        ]);
    }
}
