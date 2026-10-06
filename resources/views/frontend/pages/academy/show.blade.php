@extends('frontend.layouts.app')

@php
    $courseTitle = $course->title ?: 'Technical Training Course';

    $requirements = collect(
        preg_split(
            '/\r\n|\r|\n/',
            $course->requirements ?: ''
        )
    )->map(fn ($item) => trim($item))->filter();

    $outcomes = collect(
        preg_split(
            '/\r\n|\r|\n/',
            $course->outcomes ?: ''
        )
    )->map(fn ($item) => trim($item))->filter();

    $curriculum = collect($course->curriculum ?? []);

    $imageExists =
        $course->featured_image
        && Storage::disk('public')->exists(
            $course->featured_image
        );
@endphp

@section(
    'title',
    $course->meta_title ?: $courseTitle
)

@section(
    'meta_description',
    $course->meta_description
        ?: ($course->short_description
            ?: 'Explore practical technical training and apply online.')
)

@section('content')
    <section class="relative min-h-[700px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950">
        @if ($imageExists)
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($course->featured_image) }}"
                    alt="{{ $courseTitle }}"
                    class="h-full w-full object-cover"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
            </div>
        @endif

        <div class="relative mx-auto grid min-h-[700px] max-w-7xl items-center gap-12 px-4 py-24 sm:px-6 lg:grid-cols-[1fr_380px] lg:px-8">
            <div>
                <a
                    href="{{ route('academy') }}"
                    class="text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                >
                    ← Back to Academy
                </a>

                <p class="mt-10 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    {{ $course->category?->name
                        ?: 'Technical Training' }}
                </p>

                <h1 class="mt-5 text-5xl font-black leading-[1.02] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                    {{ $courseTitle }}
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg">
                    {{ $course->short_description
                        ?: 'Practical training designed around real technical tools, projects, and skills.' }}
                </p>

                <a
                    href="{{ route(
                        'academy.courses.apply',
                        $course
                    ) }}"
                    class="mt-9 inline-flex rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-7 py-4 text-sm font-black text-white"
                >
                    Apply for This Course
                </a>
            </div>

            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 backdrop-blur-xl">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Course Information
                </p>

                <dl class="mt-6 space-y-5">
                    @foreach ([
                        'Duration' => $course->duration ?: 'Flexible',
                        'Delivery' => $course->delivery_mode ?: 'Practical',
                        'Schedule' => $course->schedule ?: 'To be confirmed',
                        'Location' => $course->location ?: 'VTLABS',
                        'Start Date' => $course->start_date
                            ? $course->start_date->format('d M Y')
                            : 'To be announced',
                    ] as $label => $value)
                        <div class="flex justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                {{ $label }}
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ $value }}
                            </dd>
                        </div>
                    @endforeach
                </dl>

                <div class="mt-6">
                    @if ($course->fee)
                        <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                            Course Fee
                        </p>

                        <p class="mt-2 text-3xl font-black text-slate-900 dark:text-white">
                            {{ $course->currency ?: 'RWF' }}
                            {{ number_format(
                                (float) $course->fee,
                                0
                            ) }}
                        </p>
                    @else
                        <p class="font-black text-brand-primary">
                            Contact the Academy for Fees
                        </p>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Course Overview
                </p>

                <h2 class="mt-5 text-4xl font-black text-slate-900 dark:text-white">
                    What you will learn
                </h2>
            </div>

            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-8">
                <div class="whitespace-pre-line text-base leading-9 text-slate-600 dark:text-slate-400">
                    {{ $course->description
                        ?: 'This course combines technical concepts, practical exercises, guided projects, and applied problem-solving.' }}
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-8">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Requirements
                </p>

                <div class="mt-7 space-y-4">
                    @forelse ($requirements as $requirement)
                        <div class="flex gap-4">
                            <span class="text-brand-primary">✓</span>

                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                {{ $requirement }}
                            </p>
                        </div>
                    @empty
                        @foreach ([
                            'Interest in practical technical learning',
                            'Commitment to attend and complete projects',
                            'Basic communication and problem-solving skills',
                        ] as $requirement)
                            <div class="flex gap-4">
                                <span class="text-brand-primary">✓</span>

                                <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    {{ $requirement }}
                                </p>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </article>

            <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-8">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Learning Outcomes
                </p>

                <div class="mt-7 space-y-4">
                    @forelse ($outcomes as $outcome)
                        <div class="flex gap-4">
                            <span class="text-brand-primary">→</span>

                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                {{ $outcome }}
                            </p>
                        </div>
                    @empty
                        @foreach ([
                            'Understand the main technical concepts',
                            'Use relevant tools and development methods',
                            'Complete a practical project',
                            'Apply the acquired skills independently',
                        ] as $outcome)
                            <div class="flex gap-4">
                                <span class="text-brand-primary">→</span>

                                <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    {{ $outcome }}
                                </p>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </article>
        </div>
    </section>

    @if ($curriculum->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Curriculum
                </p>

                <h2 class="mt-5 text-4xl font-black text-slate-900 dark:text-white">
                    Course modules
                </h2>

                <div class="mt-10 space-y-4">
                    @foreach ($curriculum as $module)
                        <article class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6">
                            <p class="text-xs font-black text-brand-primary">
                                Module {{ str_pad(
                                    $loop->iteration,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </p>

                            <h3 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                {{ is_array($module)
                                    ? data_get(
                                        $module,
                                        'title',
                                        'Course Module'
                                    )
                                    : $module }}
                            </h3>

                            @if (
                                is_array($module)
                                && data_get($module, 'description')
                            )
                                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ data_get(
                                        $module,
                                        'description'
                                    ) }}
                                </p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12">
                <h2 class="text-4xl font-black text-slate-900 dark:text-white">
                    Ready to join {{ $courseTitle }}?
                </h2>

                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400">
                    Complete the application form and our Academy team will contact you with the next steps.
                </p>

                <a
                    href="{{ route(
                        'academy.courses.apply',
                        $course
                    ) }}"
                    class="mt-8 inline-flex rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950"
                >
                    Submit Your Application
                </a>
            </div>
        </div>
    </section>
@endsection
