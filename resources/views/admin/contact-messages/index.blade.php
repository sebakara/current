@extends('admin.layouts.app')

@section('title', 'Contact Messages')

@section('content')
    <div class="space-y-8">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                Enquiries
            </p>

            <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                Contact Messages
            </h1>

            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                Review website enquiries, assign responsibility, and track replies.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach ([
                'all' => ['All Messages', $counts['all']],
                'new' => ['New', $counts['new']],
                'in-progress' => ['In Progress', $counts['in-progress']],
                'replied' => ['Replied', $counts['replied']],
                'closed' => ['Closed', $counts['closed']],
            ] as $key => [$label, $count])
                <a
                    href="{{ route(
                        'admin.contact-messages.index',
                        array_filter([
                            'status' => $key,
                            'search' => $search ?: null,
                            'department' => $department ?: null,
                        ])
                    ) }}"
                    class="rounded-[1.5rem] border p-5 transition
                        {{ $status === $key
                            ? 'border-brand-primary/30 bg-brand-primary/[0.08]'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 hover:bg-slate-100 dark:hover:bg-white/[0.03]'
                        }}"
                >
                    <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                        {{ $label }}
                    </p>

                    <p class="mt-3 text-3xl font-black text-slate-900 dark:text-white">
                        {{ number_format($count) }}
                    </p>
                </a>
            @endforeach
        </div>

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 lg:grid-cols-[1fr_220px_190px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search name, subject, email, phone..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="department"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="">All departments</option>

                @foreach ($departments as $departmentOption)
                    <option
                        value="{{ $departmentOption }}"
                        @selected($department === $departmentOption)
                    >
                        {{ $departmentOption }}
                    </option>
                @endforeach
            </select>

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All statuses',
                    'new' => 'New',
                    'read' => 'Read',
                    'in-progress' => 'In progress',
                    'replied' => 'Replied',
                    'closed' => 'Closed',
                    'spam' => 'Spam',
                ] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected($status === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.contact-messages.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Sender
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Subject
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Received
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-white/[0.07]">
                        @forelse ($messages as $message)
                            @php
                                $statusClasses = match ($message->status) {
                                    'new' => 'bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light',
                                    'read' => 'bg-brand-secondary-light/10 text-brand-secondary dark:text-brand-secondary-light',
                                    'in-progress' => 'bg-amber-400/10 text-amber-700 dark:text-amber-300',
                                    'replied' => 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300',
                                    'closed' => 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400',
                                    'spam' => 'bg-red-400/10 text-red-700 dark:text-red-300',
                                    default => 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400',
                                };
                            @endphp

                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $message->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-500">
                                        {{ $message->phone }}
                                    </p>

                                    @if ($message->email)
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $message->email }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <p class="max-w-md font-black text-slate-700 dark:text-slate-300">
                                        {{ $message->subject }}
                                    </p>

                                    <p class="mt-2 max-w-md line-clamp-2 text-xs leading-6 text-slate-600 dark:text-slate-600">
                                        {{ $message->message }}
                                    </p>
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-500">
                                    {{ $message->created_at->format('d M Y') }}

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $message->created_at->format('H:i') }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="rounded-full px-3 py-1.5 text-xs font-black {{ $statusClasses }}">
                                        {{ str($message->status)
                                            ->replace('-', ' ')
                                            ->title() }}
                                    </span>

                                    @if ($message->assignee)
                                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $message->assignee->name }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.contact-messages.show',
                                                $message
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Open
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.contact-messages.destroy',
                                                $message
                                            ) }}"
                                            onsubmit="return confirm('Delete this message permanently?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-4 py-2 text-xs font-black text-red-700 dark:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No contact messages found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Website contact enquiries will appear here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $messages->links() }}
    </div>
@endsection
