@extends('admin.layouts.app')

@section('title', $page->title . ' Sections')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <a
                    href="{{ route('admin.pages.index') }}"
                    class="text-sm font-bold text-slate-600 dark:text-slate-500 hover:text-brand-primary dark:hover:text-brand-primary-light"
                >
                    ← Back to Pages
                </a>

                <p class="mt-8 text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Page Sections
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $page->title }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Manage the content blocks for the
                    <span class="font-black text-slate-700 dark:text-slate-300">
                        {{ $page->slug }}
                    </span>
                    page.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.pages.edit', $page) }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white"
                >
                    Edit Page
                </a>

                <a
                    href="{{ route(
                        'admin.pages.sections.create',
                        $page
                    ) }}"
                    class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
                >
                    + New Section
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($sections->isNotEmpty())
            <div class="space-y-4">
                @foreach ($sections as $section)
                    <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                        <div class="flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                            <div class="flex min-w-0 items-center gap-5">
                                <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                    @if (
                                        $section->image
                                        && Storage::disk('public')->exists(
                                            $section->image
                                        )
                                    )
                                        <img
                                            src="{{ Storage::url(
                                                $section->image
                                            ) }}"
                                            alt="{{ $section->title }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                            {{ $section->sort_order }}
                                        </span>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h2 class="truncate text-lg font-black text-slate-900 dark:text-white">
                                            {{ $section->title
                                                ?: str($section->section_key)
                                                    ->replace('_', ' ')
                                                    ->title() }}
                                        </h2>

                                        <span class="rounded-full px-3 py-1 text-xs font-black
                                            {{ $section->is_active
                                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                            }}"
                                        >
                                            {{ $section->is_active
                                                ? 'Active'
                                                : 'Inactive' }}
                                        </span>
                                    </div>

                                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                                        Key: {{ $section->section_key }}
                                        · Layout:
                                        {{ $section->layout
                                            ? str($section->layout)
                                                ->replace('-', ' ')
                                                ->title()
                                            : 'Default' }}
                                        · Order: {{ $section->sort_order }}
                                    </p>

                                    @if ($section->subtitle)
                                        <p class="mt-2 max-w-2xl truncate text-sm text-slate-600 dark:text-slate-500">
                                            {{ $section->subtitle }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex shrink-0 gap-2">
                                <a
                                    href="{{ route(
                                        'admin.pages.sections.edit',
                                        [$page, $section]
                                    ) }}"
                                    class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2.5 text-xs font-black text-slate-900 dark:text-white"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'admin.pages.sections.destroy',
                                        [$page, $section]
                                    ) }}"
                                    onsubmit="return confirm('Delete this page section?')"
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
                    No sections found
                </p>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-600">
                    Create the first section for this page.
                </p>

                <a
                    href="{{ route(
                        'admin.pages.sections.create',
                        $page
                    ) }}"
                    class="mt-7 inline-flex rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Create Section
                </a>
            </div>
        @endif
    </div>
@endsection
