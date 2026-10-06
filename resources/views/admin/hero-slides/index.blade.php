@extends('admin.layouts.app')

@section('title', 'Hero Slides')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Homepage Content
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Hero Slides
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage the main homepage banners, messages, images, and buttons.
                </p>
            </div>

            <a
                href="{{ route('admin.hero-slides.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Hero Slide
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($slides->isNotEmpty())
            <div class="space-y-5">
                @foreach ($slides as $slide)
                    <article class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
                        <div class="grid lg:grid-cols-[310px_1fr]">
                            <div class="h-64 bg-slate-50 dark:bg-slate-950 lg:h-full">
                                @if (
                                    $slide->background_image
                                    && Storage::disk('public')->exists(
                                        $slide->background_image
                                    )
                                )
                                    <img
                                        src="{{ Storage::url(
                                            $slide->background_image
                                        ) }}"
                                        alt="{{ $slide->title }}"
                                        class="h-full w-full object-cover"
                                    >
                                @else
                                    <div class="flex h-full min-h-64 items-center justify-center">
                                        <span class="text-sm font-black text-slate-600 dark:text-slate-600">
                                            No image
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-7">
                                <div class="flex flex-col justify-between gap-6 xl:flex-row">
                                    <div class="max-w-3xl">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <span class="rounded-full px-3 py-1.5 text-xs font-black
                                                {{ $slide->is_active
                                                    ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                                    : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                                }}"
                                            >
                                                {{ $slide->is_active
                                                    ? 'Active'
                                                    : 'Inactive' }}
                                            </span>

                                            <span class="rounded-full bg-brand-primary/10 px-3 py-1.5 text-xs font-black text-brand-primary dark:text-brand-primary-light">
                                                Order {{ $slide->sort_order }}
                                            </span>

                                            <span class="rounded-full bg-slate-50 dark:bg-white/[0.05] px-3 py-1.5 text-xs font-black text-slate-600 dark:text-slate-400">
                                                Text {{ ucfirst($slide->text_position) }}
                                            </span>
                                        </div>

                                        @if ($slide->eyebrow)
                                            <p class="mt-5 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                                {{ $slide->eyebrow }}
                                            </p>
                                        @endif

                                        <h2 class="mt-3 text-2xl font-black leading-tight text-slate-900 dark:text-white">
                                            {{ $slide->title }}
                                        </h2>

                                        @if ($slide->description)
                                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                                {{ $slide->description }}
                                            </p>
                                        @endif

                                        <div class="mt-5 flex flex-wrap gap-3 text-xs">
                                            @if ($slide->primary_button_text)
                                                <span class="rounded-xl bg-brand-primary/10 px-3 py-2 font-black text-brand-primary dark:text-brand-primary-light">
                                                    {{ $slide->primary_button_text }}
                                                </span>
                                            @endif

                                            @if ($slide->secondary_button_text)
                                                <span class="rounded-xl border border-slate-200 dark:border-white/10 px-3 py-2 font-black text-slate-600 dark:text-slate-400">
                                                    {{ $slide->secondary_button_text }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex shrink-0 gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.hero-slides.show',
                                                $slide
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-4 py-2.5 text-xs font-black text-slate-700 dark:text-slate-300"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route(
                                                'admin.hero-slides.edit',
                                                $slide
                                            ) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2.5 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.hero-slides.destroy',
                                                $slide
                                            ) }}"
                                            onsubmit="return confirm('Delete this hero slide?')"
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
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/50 px-6 py-20 text-center">
                <p class="text-xl font-black text-slate-900 dark:text-white">
                    No hero slides found
                </p>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-600">
                    Create the first homepage hero slide.
                </p>

                <a
                    href="{{ route('admin.hero-slides.create') }}"
                    class="mt-7 inline-flex rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Create Hero Slide
                </a>
            </div>
        @endif
    </div>
@endsection
