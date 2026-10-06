@extends('admin.layouts.app')

@section('title', 'Footer Sections')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Footer Navigation
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    Footer Sections
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Manage footer columns and their links.
                </p>
            </div>

            <a
                href="{{ route(
                    'admin.footer-sections.create'
                ) }}"
                class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Footer Section
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($sections as $section)
                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                                {{ $section->title }}
                            </h2>

                            <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                                {{ $section->section_key }}
                            </p>
                        </div>

                        <span class="rounded-full px-3 py-1.5 text-xs font-black
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

                    <p class="mt-5 text-sm text-slate-600 dark:text-slate-500">
                        {{ $section->links_count }} links
                        · Order {{ $section->sort_order }}
                    </p>

                    <div class="mt-6 flex gap-2">
                        <a
                            href="{{ route(
                                'admin.footer-sections.show',
                                $section
                            ) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-900 dark:text-white"
                        >
                            Manage Links
                        </a>

                        <a
                            href="{{ route(
                                'admin.footer-sections.edit',
                                $section
                            ) }}"
                            class="rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-xs font-black text-slate-700 dark:text-slate-300"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.footer-sections.destroy',
                                $section
                            ) }}"
                            onsubmit="return confirm('Delete this footer section?')"
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
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No footer sections found
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
