@extends('admin.layouts.app')

@section('title', 'Project Categories')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Portfolio Management
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Project Categories
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Organise completed work into clear public portfolio groups.
                </p>
            </div>

            <a
                href="{{ route('admin.project-categories.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Category
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm font-semibold text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <form
            method="GET"
            class="flex flex-col gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 sm:flex-row"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search project categories..."
                class="min-w-0 flex-1 rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Search
            </button>

            @if ($search !== '')
                <a
                    href="{{ route('admin.project-categories.index') }}"
                    class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
                >
                    Reset
                </a>
            @endif
        </form>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Projects
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Order
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-white/[0.07]">
                        @forelse ($categories as $category)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $category->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $category->slug }}
                                    </p>

                                    @if ($category->description)
                                        <p class="mt-2 max-w-md line-clamp-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                            {{ $category->description }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm font-black text-slate-700 dark:text-slate-300">
                                    {{ number_format($category->projects_count) }}
                                </td>

                                <td class="px-6 py-5">
                                    @if ($category->is_active)
                                        <span class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-black text-emerald-700 dark:text-emerald-300">
                                            Active
                                        </span>
                                    @else
                                        <span class="rounded-full border border-slate-200 dark:border-slate-400/15 bg-slate-100 dark:bg-slate-400/10 px-3 py-1.5 text-xs font-black text-slate-600 dark:text-slate-400">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-500">
                                    {{ $category->sort_order }}
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.project-categories.show',
                                                $category
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-3 py-2 text-xs font-black text-slate-700 dark:text-slate-300"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route(
                                                'admin.project-categories.edit',
                                                $category
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.project-categories.destroy',
                                                $category
                                            ) }}"
                                            onsubmit="return confirm('Delete this project category?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-3 py-2 text-xs font-black text-red-700 dark:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="5"
                                    class="px-6 py-16 text-center"
                                >
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No project categories found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Create the first category for your project portfolio.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $categories->links() }}
    </div>
@endsection
