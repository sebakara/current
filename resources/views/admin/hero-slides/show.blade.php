@extends('admin.layouts.app')

@section('title', 'Hero Slide Preview')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Hero Slide Preview
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    {{ $heroSlide->title }}
                </h1>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route('admin.hero-slides.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.hero-slides.edit',
                        $heroSlide
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit Slide
                </a>
            </div>
        </div>

        <section class="relative min-h-[620px] overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
            @if (
                $heroSlide->background_image
                && Storage::disk('public')->exists(
                    $heroSlide->background_image
                )
            )
                <img
                    src="{{ Storage::url(
                        $heroSlide->background_image
                    ) }}"
                    alt="{{ $heroSlide->title }}"
                    class="absolute inset-0 h-full w-full object-cover"
                >
            @endif

            <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-slate-50 dark:via-slate-950/75 to-slate-100 dark:to-slate-950/20"></div>

            <div class="relative flex min-h-[620px] items-center px-8 py-16 sm:px-14 lg:px-20">
                <div class="max-w-3xl
                    {{ $heroSlide->text_position === 'center'
                        ? 'mx-auto text-center'
                        : ($heroSlide->text_position === 'right'
                            ? 'ml-auto text-right'
                            : '')
                    }}"
                >
                    @if ($heroSlide->eyebrow)
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            {{ $heroSlide->eyebrow }}
                        </p>
                    @endif

                    <h2 class="mt-5 text-4xl font-black leading-tight text-slate-900 dark:text-white sm:text-6xl">
                        {{ $heroSlide->title }}
                    </h2>

                    @if ($heroSlide->description)
                        <p class="mt-6 text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg">
                            {{ $heroSlide->description }}
                        </p>
                    @endif

                    <div class="mt-8 flex flex-wrap gap-4
                        {{ $heroSlide->text_position === 'center'
                            ? 'justify-center'
                            : ($heroSlide->text_position === 'right'
                                ? 'justify-end'
                                : '')
                        }}"
                    >
                        @if ($heroSlide->primary_button_text)
                            <span class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950">
                                {{ $heroSlide->primary_button_text }}
                            </span>
                        @endif

                        @if ($heroSlide->secondary_button_text)
                            <span class="rounded-2xl border border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-white/[0.05] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white">
                                {{ $heroSlide->secondary_button_text }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
