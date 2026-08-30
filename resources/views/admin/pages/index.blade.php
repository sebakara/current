@extends('admin.layouts.app')

@section('title', 'Pages')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Website Content
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Pages
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage page-level content, templates, SEO, and publishing.
                </p>
            </div>

            <a
                href="{{ route('admin.pages.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Page
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
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[1fr_200px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search title, slug, subtitle, or template..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="all" @selected($status === 'all')>
                    All pages
                </option>

                <option
                    value="published"
                    @selected($status === 'published')
                >
                    Published
                </option>

                <option value="draft" @selected($status === 'draft')>
                    Draft
                </option>
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.pages.index') }}"
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
                                Page
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Template
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Sections
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
                        @forelse ($pages as $page)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $page->title }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $page->slug }}
                                    </p>

                                    @if ($page->subtitle)
                                        <p class="mt-2 max-w-md line-clamp-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                            {{ $page->subtitle }}
                                        </p>
                                    @endif
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $page->template
                                        ? str($page->template)
                                            ->replace('-', ' ')
                                            ->title()
                                        : 'Default' }}
                                </td>

                                <td class="px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $page->active_sections_count }}
                                        active
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $page->sections_count }} total
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <span class="rounded-full px-3 py-1.5 text-xs font-black
                                        {{ $page->is_published
                                            ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                            : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                        }}"
                                    >
                                        {{ $page->is_published
                                            ? 'Published'
                                            : 'Draft' }}
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.pages.show',
                                                $page
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-3 py-2 text-xs font-black text-slate-700 dark:text-slate-300"
                                        >
                                            Sections
                                        </a>

                                        <a
                                            href="{{ route(
                                                'admin.pages.edit',
                                                $page
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.pages.destroy',
                                                $page
                                            ) }}"
                                            onsubmit="return confirm('Delete this page?')"
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
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No pages found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Create the first website page.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $pages->links() }}
    </div>
@endsection
