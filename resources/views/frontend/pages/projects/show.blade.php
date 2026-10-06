@extends('frontend.layouts.app')

@php
    $projectTitle = $project->title ?: 'Technical Project';

    $projectDescription = $project->short_description
        ?: 'A practical engineering and technology project developed around real technical requirements.';

    $featuredImageExists =
        $project->featured_image
        && Storage::disk('public')->exists(
            $project->featured_image
        );

    $gallery = collect($project->gallery ?? [])
        ->filter(
            fn ($image) => $image
                && Storage::disk('public')->exists($image)
        );

    $technologies = collect($project->technologies ?? [])
        ->filter();

    $challenge = $project->challenge
        ?: 'The project required a reliable technical approach capable of meeting practical operational, usability, quality, and implementation requirements.';

    $solution = $project->solution
        ?: 'Our team analysed the requirements, developed the technical approach, designed and tested the solution, and prepared it for practical implementation.';

    $results = $project->results
        ?: 'The completed project provided a practical foundation for improved performance, technical capability, and continued development.';
@endphp

@section(
    'title',
    $project->meta_title ?: $projectTitle
)

@section(
    'meta_description',
    $project->meta_description ?: $projectDescription
)

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[760px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950">
        @if ($featuredImageExists)
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url(
                        $project->featured_image
                    ) }}"
                    alt="{{ $projectTitle }}"
                    class="h-full w-full object-cover"
                >

                <div class="absolute inset-0 bg-white/60 dark:bg-slate-950/60"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/30 dark:to-slate-950/30"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-brand-primary-dark/10 blur-[130px]"></div>

                <div class="absolute -right-32 bottom-0 h-[30rem] w-[30rem] rounded-full bg-brand-secondary/10 blur-[150px]"></div>

                <div
                    class="absolute inset-0 opacity-[0.04] text-slate-900 dark:text-white"
                    style="
                        background-image:
                        linear-gradient(currentColor 1px, transparent 1px),
                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                        background-size: 52px 52px;
                    "
                ></div>
            </div>
        @endif

        <div class="relative mx-auto grid min-h-[760px] max-w-7xl items-center gap-12 px-4 py-24 sm:px-6 lg:grid-cols-[1fr_0.65fr] lg:px-8">
            <div data-reveal="up">
                <a
                    href="{{ route('projects') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-400 transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                >
                    ← Back to Projects
                </a>

                <p class="mt-10 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    {{ $project->category?->name
                        ?: 'Technical Project' }}
                </p>

                <h1 class="mt-5 max-w-5xl text-5xl font-black leading-[1.02] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                    {{ $projectTitle }}
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg">
                    {{ $projectDescription }}
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route('contact') }}"
                        class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white shadow-[0_18px_50px_rgba(34,211,238,0.18)] transition hover:-translate-y-1"
                    >
                        Start a Similar Project
                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </a>

                    @if ($project->project_url)
                        <a
                            href="{{ $project->project_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                        >
                            Visit Project
                            <span>↗</span>
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden lg:block" data-reveal="scale">
                <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/65 p-7 backdrop-blur-2xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Project Overview
                    </p>

                    <dl class="mt-6 space-y-5">
                        <div class="flex items-start justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Category
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ $project->category?->name
                                    ?: 'General Project' }}
                            </dd>
                        </div>

                        <div class="flex items-start justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Client
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ $project->client_name
                                    ?: 'Confidential Client' }}
                            </dd>
                        </div>

                        <div class="flex items-start justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Location
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ $project->location
                                    ?: 'Rwanda' }}
                            </dd>
                        </div>

                        <div class="flex items-start justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Completed
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ $project->completion_date
                                    ? $project->completion_date->format('F Y')
                                    : 'Project Delivered' }}
                            </dd>
                        </div>

                        <div class="flex items-start justify-between gap-5">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Views
                            </dt>

                            <dd class="text-right text-sm font-black text-slate-900 dark:text-white">
                                {{ number_format(
                                    (int) $project->views
                                ) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    {{-- Project description --}}
    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Project Context
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    Understanding the project
                </h2>
            </div>

            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-7 sm:p-9"
                data-reveal="right"
            >
                <div class="whitespace-pre-line text-base leading-9 text-slate-600 dark:text-slate-400">
                    {{ $project->description
                        ?: 'This project combined technical analysis, design, implementation, testing, and practical delivery. The work was structured around the client’s objectives, expected users, operating environment, available resources, and long-term development needs.' }}
                </div>
            </div>
        </div>
    </section>

    {{-- Challenge, solution and results --}}
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-24">
        <div class="pointer-events-none absolute -left-40 top-1/2 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <article
                    class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                    data-reveal="up"
                >
                    <span class="text-6xl font-black text-slate-200 dark:text-white/[0.04]">
                        01
                    </span>

                    <p class="mt-7 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Challenge
                    </p>

                    <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                        The problem
                    </h2>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-500">
                        {{ $challenge }}
                    </p>
                </article>

                <article
                    class="relative overflow-hidden rounded-[2rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/[0.08] to-slate-100 dark:to-slate-900 p-7"
                    data-reveal="up"
                >
                    <span class="text-6xl font-black text-slate-200 dark:text-white/[0.04]">
                        02
                    </span>

                    <p class="mt-7 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Solution
                    </p>

                    <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                        Our approach
                    </h2>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $solution }}
                    </p>
                </article>

                <article
                    class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                    data-reveal="up"
                >
                    <span class="text-6xl font-black text-slate-200 dark:text-white/[0.04]">
                        03
                    </span>

                    <p class="mt-7 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Results
                    </p>

                    <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                        The impact
                    </h2>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-500">
                        {{ $results }}
                    </p>
                </article>
            </div>
        </div>
    </section>

    {{-- Technologies --}}
    @if ($technologies->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-20">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:items-center lg:px-8">
                <div data-reveal="left">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        Technology Stack
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                        Tools and technologies
                    </h2>
                </div>

                <div
                    class="flex flex-wrap gap-3"
                    data-reveal="right"
                >
                    @foreach ($technologies as $technology)
                        <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] px-5 py-3 text-sm font-black text-slate-700 dark:text-slate-300 transition hover:border-brand-primary/20 hover:bg-brand-primary/[0.06] hover:text-brand-primary-dark dark:hover:text-brand-primary-light">
                            {{ is_array($technology)
                                ? data_get(
                                    $technology,
                                    'name',
                                    'Technology'
                                )
                                : $technology }}
                        </span>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery --}}
    @if ($gallery->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        Project Gallery
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        Behind the implementation
                    </h2>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($gallery as $image)
                        <div
                            class="
                                group overflow-hidden rounded-[2rem]
                                border border-slate-200 dark:border-white/10
                                {{ $loop->first
                                    ? 'sm:col-span-2 lg:col-span-2'
                                    : ''
                                }}
                            "
                            data-reveal="scale"
                        >
                            <img
                                src="{{ Storage::url($image) }}"
                                alt="{{ $projectTitle }}"
                                class="
                                    w-full object-cover transition duration-700
                                    group-hover:scale-105
                                    {{ $loop->first
                                        ? 'h-[500px]'
                                        : 'h-72'
                                    }}
                                "
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Related projects --}}
    @if ($relatedProjects->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex items-end justify-between gap-6"
                    data-reveal="up"
                >
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            Related Work
                        </p>

                        <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                            Explore similar projects
                        </h2>
                    </div>

                    <a
                        href="{{ route('projects') }}"
                        class="hidden text-sm font-black text-brand-primary transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light sm:inline-flex"
                    >
                        View All Projects →
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedProjects as $relatedProject)
                        <a
                            href="{{ route(
                                'projects.show',
                                $relatedProject
                            ) }}"
                            class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition hover:-translate-y-2 hover:border-brand-primary/25"
                            data-reveal="up"
                        >
                            <div class="relative h-64 overflow-hidden">
                                @if (
                                    $relatedProject->featured_image
                                    && Storage::disk('public')->exists(
                                        $relatedProject->featured_image
                                    )
                                )
                                    <img
                                        src="{{ Storage::url(
                                            $relatedProject->featured_image
                                        ) }}"
                                        alt="{{ $relatedProject->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                    >

                                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10">
                                        <span class="text-6xl font-black text-slate-200 dark:text-white/[0.06]">
                                            {{ strtoupper(substr(
                                                $relatedProject->title ?: 'VT',
                                                0,
                                                2
                                            )) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-7">
                                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                    {{ $relatedProject->category?->name
                                        ?: 'Project' }}
                                </p>

                                <h3 class="mt-3 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $relatedProject->title }}
                                </h3>

                                <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $relatedProject->short_description
                                        ?: 'A practical engineering and technology project.' }}
                                </p>

                                <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        View Project
                                    </span>

                                    <span class="transition group-hover:translate-x-1">
                                        →
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12 lg:p-14"
                data-reveal="scale"
            >
                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-primary/10 blur-[90px]"></div>

                <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            Your Project
                        </p>

                        <h2 class="mt-5 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                            Need a solution built around your challenge?
                        </h2>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                            Share your objectives and requirements so our team can assess the right engineering, manufacturing, software, research, or training approach.
                        </p>
                    </div>

                    <a
                        href="{{ route('contact') }}"
                        class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                    >
                        Discuss Your Project

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
