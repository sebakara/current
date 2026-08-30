<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    private const STATUSES = [
        'new',
        'read',
        'in-progress',
        'replied',
        'closed',
        'spam',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = (string) $request->query('status', 'all');
        $department = trim((string) $request->query('department'));

        $messages = ContactMessage::query()
            ->with('assignee')
            ->when($search !== '', function (Builder $query) use ($search) {
                $query->where(function (Builder $innerQuery) use ($search) {
                    $innerQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('company', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when(
                $status !== 'all'
                && in_array($status, self::STATUSES, true),
                fn (Builder $query) => $query->where('status', $status)
            )
            ->when(
                $department !== '',
                fn (Builder $query) => $query->where(
                    'department',
                    $department
                )
            )
            ->latest('created_at')
            ->paginate(25)
            ->withQueryString();

        $counts = [
            'all' => ContactMessage::query()->count(),
            'new' => ContactMessage::query()
                ->where('status', 'new')
                ->count(),
            'in-progress' => ContactMessage::query()
                ->where('status', 'in-progress')
                ->count(),
            'replied' => ContactMessage::query()
                ->where('status', 'replied')
                ->count(),
            'closed' => ContactMessage::query()
                ->where('status', 'closed')
                ->count(),
        ];

        $departments = ContactMessage::query()
            ->whereNotNull('department')
            ->where('department', '!=', '')
            ->distinct()
            ->orderBy('department')
            ->pluck('department');

        return view('admin.contact-messages.index', compact(
            'messages',
            'counts',
            'departments',
            'search',
            'status',
            'department'
        ));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if ($contactMessage->read_at === null) {
            $contactMessage->update([
                'read_at' => now(),
                'status' => $contactMessage->status === 'new'
                    ? 'read'
                    : $contactMessage->status,
            ]);
        }

        $contactMessage->load('assignee');

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view(
            'admin.contact-messages.show',
            compact('contactMessage', 'users')
        );
    }

    public function update(
        Request $request,
        ContactMessage $contactMessage
    ): RedirectResponse {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(self::STATUSES),
            ],
            'department' => [
                'nullable',
                'string',
                'max:100',
            ],
            'assigned_to' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id'),
            ],
            'internal_notes' => [
                'nullable',
                'string',
                'max:10000',
            ],
            'admin_notes' => [
                'nullable',
                'string',
                'max:10000',
            ],
        ]);

        if ($contactMessage->read_at === null) {
            $validated['read_at'] = now();
        }

        $contactMessage->update($validated);

        return redirect()
            ->route(
                'admin.contact-messages.show',
                $contactMessage
            )
            ->with('success', 'Contact message updated successfully.');
    }

    public function destroy(
        ContactMessage $contactMessage
    ): RedirectResponse {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
