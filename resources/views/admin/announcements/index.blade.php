@extends('admin.layouts.app')

@section('title', 'Announcements')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Website Notices
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Announcements
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage scheduled notices, alerts, and promotions.
                </p>
            </div>

            <a
                href="{{ route('admin.announcements.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Announcement
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[220px_220px_auto_auto]"
        >
            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All announcements',
                    'active' => 'Currently active',
                    'inactive' => 'Inactive',
                    'scheduled' => 'Scheduled',
                    'expired' => 'Expired',
                ] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected($status === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <select
                name="type"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All types',
                    'info' => 'Information',
                    'success' => 'Success',
                    'warning' => 'Warning',
                    'danger' => 'Danger',
                    'promotion' => 'Promotion',
                ] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected($type === $value)
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
                href="{{ route('admin.announcements.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="space-y-4">
            @forelse ($announcements as $announcement)
                @php
                    $currentlyActive =
                        $announcement->is_active
                        && (
                            ! $announcement->starts_at
                            || $announcement->starts_at->lte(now())
                        )
                        && (
                            ! $announcement->ends_at
                            || $announcement->ends_at->gte(now())
                        );

                    $typeClasses = match ($announcement->type) {
                        'success' =>
                            'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300',
                        'warning' =>
                            'bg-amber-400/10 text-amber-700 dark:text-amber-300',
                        'danger' =>
                            'bg-red-400/10 text-red-700 dark:text-red-300',
                        'promotion' =>
                            'bg-purple-400/10 text-purple-700 dark:text-purple-300',
                        default =>
                            'bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light',
                    };
                @endphp

                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                        <div class="max-w-3xl">
                            <div class="flex flex-wrap gap-2">
                                <span class="rounded-full px-3 py-1.5 text-xs font-black {{ $typeClasses }}">
                                    {{ str($announcement->type)->title() }}
                                </span>

                                <span class="rounded-full px-3 py-1.5 text-xs font-black
                                    {{ $currentlyActive
                                        ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                        : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                    }}"
                                >
                                    {{ $currentlyActive
                                        ? 'Currently active'
                                        : 'Not active' }}
                                </span>
                            </div>

                            <h2 class="mt-4 text-xl font-black text-slate-900 dark:text-white">
                                {{ $announcement->title }}
                            </h2>

                            <p class="mt-3 line-clamp-2 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $announcement->message }}
                            </p>

                            <p class="mt-4 text-xs text-slate-600 dark:text-slate-600">
                                Starts:
                                {{ $announcement->starts_at
                                    ? $announcement->starts_at
                                        ->format('d M Y, H:i')
                                    : 'Immediately' }}

                                · Ends:
                                {{ $announcement->ends_at
                                    ? $announcement->ends_at
                                        ->format('d M Y, H:i')
                                    : 'No expiry' }}
                            </p>
                        </div>

                        <div class="flex shrink-0 gap-2">
                            <a
                                href="{{ route(
                                    'admin.announcements.show',
                                    $announcement
                                ) }}"
                                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-4 py-2.5 text-xs font-black text-slate-700 dark:text-slate-300"
                            >
                                View
                            </a>

                            <a
                                href="{{ route(
                                    'admin.announcements.edit',
                                    $announcement
                                ) }}"
                                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2.5 text-xs font-black text-slate-900 dark:text-white"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.announcements.destroy',
                                    $announcement
                                ) }}"
                                onsubmit="return confirm('Delete this announcement?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-4 py-2.5 text-xs font-black text-red-700 dark:text-red-300"
                                >
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/50 px-6 py-20 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No announcements found
                    </p>

                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-600">
                        Create the first website notice or promotion.
                    </p>
                </div>
            @endforelse
        </div>

        {{ $announcements->links() }}
    </div>
@endsection
