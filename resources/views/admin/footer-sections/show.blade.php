@extends('admin.layouts.app')

@section('title', $footerSection->title)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Footer Section
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $footerSection->title }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $footerSection->section_key }}
                </p>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route(
                        'admin.footer-sections.index'
                    ) }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.footer-sections.links.create',
                        $footerSection
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    + Add Footer Link
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-3">
            @forelse ($footerSection->links as $link)
                <article class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-5 sm:flex-row sm:items-center">
                    <div>
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 class="font-black text-slate-900 dark:text-white">
                                {{ $link->label }}
                            </h2>

                            <span class="rounded-full px-3 py-1 text-xs font-black
                                {{ $link->is_active
                                    ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                    : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                }}"
                            >
                                {{ $link->is_active
                                    ? 'Active'
                                    : 'Inactive' }}
                            </span>
                        </div>

                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                            {{ $link->route_name
                                ?: $link->url
                                ?: '#' }}
                            · Order {{ $link->sort_order }}
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <a
                            href="{{ route(
                                'admin.footer-sections.links.edit',
                                [$footerSection, $link]
                            ) }}"
                            class="rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-xs font-black text-slate-900 dark:text-white"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.footer-sections.links.destroy',
                                [$footerSection, $link]
                            ) }}"
                            onsubmit="return confirm('Delete this footer link?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl border border-red-400/15 px-4 py-2.5 text-xs font-black text-red-700 dark:text-red-300"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No footer links found
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
