@extends('admin.layouts.app')

@section('title', $page->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Website Page
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $page->title }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $page->slug }}
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a
                    href="{{ route('admin.pages.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back to Pages
                </a>


<a
    href="{{ route(
        'admin.pages.sections.index',
        $page
    ) }}"
    class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
>
    Manage Sections
</a>


                <a
                    href="{{ route('admin.pages.edit', $page) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit Page
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-7 lg:grid-cols-[1fr_330px]">
            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Page Sections
                </p>

                @if ($page->sections->isNotEmpty())
                    <div class="mt-6 divide-y divide-slate-200 dark:divide-white/[0.07]">
                        @foreach ($page->sections as $section)
                            <div class="flex flex-col justify-between gap-4 py-5 first:pt-0 last:pb-0 sm:flex-row sm:items-center">
                                <div>
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $section->title
                                            ?: str($section->section_key)
                                                ->replace('_', ' ')
                                                ->title() }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $section->section_key }}
                                        · Order {{ $section->sort_order }}
                                    </p>
                                </div>

                                <span class="w-fit rounded-full px-3 py-1.5 text-xs font-black
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
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border border-dashed border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950/60 p-8 text-center">
                        <p class="font-black text-slate-900 dark:text-white">
                            No sections created
                        </p>

                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                            The Page Sections editor will be added in the next step.
                        </p>
                    </div>
                @endif
            </section>

            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Summary
                </p>

                <dl class="mt-6 space-y-5">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Status</dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $page->is_published
                                ? 'Published'
                                : 'Draft' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Template</dt>

                        <dd class="text-right font-black text-slate-900 dark:text-white">
                            {{ $page->template
                                ? str($page->template)
                                    ->replace('-', ' ')
                                    ->title()
                                : 'Default' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Sections</dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $page->sections->count() }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Sort order</dt>

                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $page->sort_order }}
                        </dd>
                    </div>
                </dl>
            </aside>
        </div>
    </div>
@endsection
