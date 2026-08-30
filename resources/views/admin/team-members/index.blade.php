@extends('admin.layouts.app')

@section('title', 'Team Members')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Company Profile
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Team Members
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage staff profiles displayed across the website.
                </p>
            </div>

            <a
                href="{{ route('admin.team-members.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Team Member
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 lg:grid-cols-[1fr_230px_190px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search name, role, department, or email..."
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
                <option value="all" @selected($status === 'all')>
                    All members
                </option>

                <option
                    value="active"
                    @selected($status === 'active')
                >
                    Active
                </option>

                <option
                    value="inactive"
                    @selected($status === 'inactive')
                >
                    Inactive
                </option>
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.team-members.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        @if ($members->isNotEmpty())
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($members as $member)
                    <article class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
                        <div class="aspect-[4/3] bg-slate-50 dark:bg-slate-950">
                            @if (
                                $member->photo
                                && Storage::disk('public')->exists(
                                    $member->photo
                                )
                            )
                                <img
                                    src="{{ Storage::url($member->photo) }}"
                                    alt="{{ $member->name }}"
                                    class="h-full w-full object-cover"
                                >
                            @else
                                <div class="flex h-full items-center justify-center">
                                    <span class="text-4xl font-black text-brand-primary dark:text-brand-primary-light">
                                        {{ strtoupper(
                                            substr($member->name, 0, 2)
                                        ) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-6">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <h2 class="text-xl font-black text-slate-900 dark:text-white">
                                        {{ $member->name }}
                                    </h2>

                                    <p class="mt-2 text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                        {{ $member->role }}
                                    </p>

                                    @if ($member->department)
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $member->department }}
                                        </p>
                                    @endif
                                </div>

                                <span class="rounded-full px-3 py-1.5 text-xs font-black
                                    {{ $member->is_active
                                        ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                        : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                    }}"
                                >
                                    {{ $member->is_active
                                        ? 'Active'
                                        : 'Inactive' }}
                                </span>
                            </div>

                            @if ($member->bio)
                                <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $member->bio }}
                                </p>
                            @endif

                            <div class="mt-6 flex gap-2">
                                <a
                                    href="{{ route(
                                        'admin.team-members.show',
                                        $member
                                    ) }}"
                                    class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-4 py-2.5 text-center text-xs font-black text-slate-700 dark:text-slate-300"
                                >
                                    View
                                </a>

                                <a
                                    href="{{ route(
                                        'admin.team-members.edit',
                                        $member
                                    ) }}"
                                    class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2.5 text-center text-xs font-black text-slate-900 dark:text-white"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.team-members.destroy',
                                        $member
                                    ) }}"
                                    onsubmit="return confirm('Delete this team member?')"
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
                @endforeach
            </div>
        @else
            <div class="rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/50 px-6 py-20 text-center">
                <p class="text-xl font-black text-slate-900 dark:text-white">
                    No team members found
                </p>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-600">
                    Add the first staff profile.
                </p>
            </div>
        @endif

        {{ $members->links() }}
    </div>
@endsection
