@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('projects-hero');
    $catalogueSection = $sections->get('projects-catalogue');
    $ctaSection = $sections->get('projects-cta');

    $activeCategory = $categories->firstWhere(
        'slug',
        $categorySlug
    );

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Explore Our Work'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        '#project-catalogue'
    );

    $heroSecondaryText = data_get(
        $heroSection?->data,
        'secondary_button_text',
        'Start a Project'
    );

    $heroSecondaryUrl = data_get(
        $heroSection?->data,
        'secondary_button_url',
        route('contact')
    );

    $ctaButtonText = data_get(
        $ctaSection?->data,
        'button_text',
        'Discuss Your Project'
    );

    $ctaButtonUrl = data_get(
        $ctaSection?->data,
        'button_url',
        route('contact')
    );

    $fallbackProjects = collect([
        [
            'title' => 'Smart Laboratory Development',
            'category' => 'Laboratory Solutions',
            'description' => 'Planning and implementation of a practical technical learning environment.',
        ],
        [
            'title' => 'Industrial Monitoring Platform',
            'category' => 'Smart Systems',
            'description' => 'An integrated hardware and software solution for operational monitoring.',
        ],
        [
            'title' => 'Custom Electronics Prototype',
            'category' => 'Electronics',
            'description' => 'From circuit concept and PCB design to testing and functional demonstration.',
        ],
        [
            'title' => 'Digital Fabrication Project',
            'category' => 'Manufacturing',
            'description' => 'Rapid prototyping and precision production using modern fabrication methods.',
        ],
        [
            'title' => 'Technical Training Programme',
            'category' => 'Education',
            'description' => 'Hands-on technical education designed around practical industry skills.',
        ],
        [
            'title' => 'Custom Software System',
            'category' => 'Software',
            'description' => 'A digital platform designed around an organisation’s operational workflow.',
        ],
    ]);
@endphp

@section(
    'title',
    $page?->meta_title
        ?: ($activeCategory?->name ?: 'Projects')
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Explore engineering, manufacturing, electronics, software, laboratory, research, and training projects.'
)

@section('content')
    {{-- Hero --}}
    <section
        class="relative min-h-[700px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950"
        data-hero-motion
    >
        @if (
            $heroSection?->image
            && Storage::disk('public')->exists($heroSection->image)
        )
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($heroSection->image) }}"
                    alt="{{ $heroSection->title ?: 'Projects' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/35 dark:to-slate-950/35"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div
                    class="absolute -left-40 top-10 h-[32rem] w-[32rem] rounded-full bg-brand-primary-dark/10 blur-[140px]"
                    data-motion-layer="18"
                ></div>

                <div
                    class="absolute -right-40 bottom-0 h-[34rem] w-[34rem] rounded-full bg-brand-secondary/10 blur-[150px]"
                    data-motion-layer="-24"
                ></div>

                <div
                    class="absolute inset-0 opacity-[0.04] text-slate-900 dark:text-white"
                    style="
                        background-image:
                        linear-gradient(currentColor 1px, transparent 1px),
                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                        background-size: 54px 54px;
                    "
                ></div>
            </div>
        @endif

        <div class="relative mx-auto grid min-h-[700px] max-w-7xl items-center gap-14 px-4 py-24 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div>
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-brand-primary/20 bg-brand-primary/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl"
                    data-hero-reveal
                >
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-primary opacity-50"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-primary"></span>
                    </span>

                    {{ $heroSection?->subtitle
                        ?: 'Engineering in Action' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.2rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Projects built to solve real problems.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'Explore engineering, manufacturing, electronics, software, laboratory, research, training, and product-development projects delivered by our team.' }}
                </p>

                <div
                    class="mt-9 flex flex-col gap-3 sm:flex-row"
                    data-hero-reveal
                >
                    @if ($heroPrimaryText && $heroPrimaryUrl)
                        <a
                            href="{{ $heroPrimaryUrl }}"
                            class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white shadow-[0_18px_50px_rgba(34,211,238,0.18)] transition hover:-translate-y-1"
                        >
                            {{ $heroPrimaryText }}

                            <span class="transition group-hover:translate-x-1">
                                →
                            </span>
                        </a>
                    @endif

                    @if ($heroSecondaryText && $heroSecondaryUrl)
                        <a
                            href="{{ $heroSecondaryUrl }}"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition hover:-translate-y-1 hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                        >
                            {{ $heroSecondaryText }}
                        </a>
                    @endif
                </div>
            </div>

            <div
                class="relative hidden min-h-[500px] lg:block"
                data-hero-reveal
            >
                <div
                    class="absolute inset-4 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl backdrop-blur-2xl"
                    data-motion-layer="14"
                ></div>

                <div
                    class="absolute inset-10 overflow-hidden rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/75 p-7"
                    data-motion-layer="22"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.08] via-transparent to-brand-secondary/[0.08]"></div>

                    <div
                        class="absolute inset-0 opacity-[0.06] text-slate-900 dark:text-white"
                        style="
                            background-image:
                            linear-gradient(currentColor 1px, transparent 1px),
                            linear-gradient(90deg, currentColor 1px, transparent 1px);
                            background-size: 36px 36px;
                        "
                    ></div>

                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                Project Lifecycle
                            </p>

                            <h2 class="mt-5 text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                Challenge to measurable result.
                            </h2>
                        </div>

                        <div class="space-y-3">
                            @foreach ([
                                'Discover',
                                'Engineer',
                                'Prototype',
                                'Deliver',
                            ] as $stage)
                                <div class="flex items-center gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-4">
                                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-brand-primary/10 text-xs font-black text-brand-primary-dark dark:text-brand-primary-light">
                                        {{ str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                    </span>

                                    <span class="font-black text-slate-900 dark:text-white">
                                        {{ $stage }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="absolute -left-2 top-16 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="34"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        R&amp;D
                    </p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Applied Innovation
                    </p>
                </div>

                <div
                    class="absolute -bottom-2 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="-28"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        360°
                    </p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Project Support
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Category filters --}}
    <section class="sticky top-20 z-30 border-b border-slate-200 dark:border-white/10 bg-white/90 dark:bg-slate-950/90 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 sm:px-6 lg:px-8">
            <div class="flex min-w-max items-center gap-2 py-4">
                <a
                    href="{{ route('projects') }}"
                    class="
                        rounded-full border px-4 py-2 text-xs font-black
                        uppercase tracking-[0.12em] transition
                        {{ !$categorySlug
                            ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                        }}
                    "
                >
                    All Projects
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route(
                            'projects',
                            ['category' => $category->slug]
                        ) }}"
                        class="
                            rounded-full border px-4 py-2 text-xs font-black
                            uppercase tracking-[0.12em] transition
                            {{ $categorySlug === $category->slug
                                ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                                : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'
                            }}
                        "
                    >
                        {{ $category->name }}

                        @if ($category->projects_count)
                            <span class="ml-1 opacity-60">
                                {{ $category->projects_count }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Projects catalogue --}}
    <section
        id="project-catalogue"
        class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24"
    >
        <div class="pointer-events-none absolute -left-40 top-1/3 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end"
                data-reveal="up"
            >
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        {{ $catalogueSection?->subtitle
                            ?: 'Selected Work' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $activeCategory?->name
                            ?: ($catalogueSection?->title
                                ?: 'Explore our projects') }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $activeCategory?->description
                            ?: ($catalogueSection?->content
                                ?: 'Discover how our multidisciplinary capabilities are applied to practical technical challenges.') }}
                    </p>
                </div>

                @if ($projects->total() > 0)
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-500">
                        {{ $projects->total() }}
                        {{ Str::plural('project', $projects->total()) }}
                    </p>
                @endif
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2">
                @forelse ($projects as $project)
                    @php
                        $projectImageExists =
                            $project->featured_image
                            && Storage::disk('public')->exists(
                                $project->featured_image
                            );
                    @endphp

                    <a
                        href="{{ route('projects.show', $project) }}"
                        class="
                            group relative overflow-hidden rounded-[2.2rem]
                            border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70
                            transition duration-500
                            hover:-translate-y-2 hover:border-brand-primary/25

                            {{ $loop->first
                                && !$categorySlug
                                && $project->is_featured
                                    ? 'md:col-span-2'
                                    : ''
                            }}
                        "
                        data-reveal="up"
                    >
                        <div
                            class="
                                relative overflow-hidden bg-slate-50 dark:bg-slate-900
                                {{ $loop->first
                                    && !$categorySlug
                                    && $project->is_featured
                                        ? 'h-[520px]'
                                        : 'h-[360px]'
                                }}
                            "
                        >
                            @if ($projectImageExists)
                                <img
                                    src="{{ Storage::url(
                                        $project->featured_image
                                    ) }}"
                                    alt="{{ $project->title }}"
                                    class="h-full w-full object-cover transition duration-1000 group-hover:scale-105"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-white/15 dark:via-slate-950/15 to-transparent"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10"></div>

                                <div
                                    class="absolute inset-0 opacity-[0.06] text-slate-900 dark:text-white"
                                    style="
                                        background-image:
                                        linear-gradient(currentColor 1px, transparent 1px),
                                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                                        background-size: 36px 36px;
                                    "
                                ></div>

                                <div class="relative flex h-full items-center justify-center">
                                    <span class="text-8xl font-black text-slate-200 dark:text-white/[0.06]">
                                        {{ strtoupper(substr(
                                            $project->title ?: 'VT',
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>
                            @endif

                            <div class="absolute inset-x-0 bottom-0 p-6 sm:p-8">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="rounded-full border border-brand-primary/20 bg-white/60 dark:bg-slate-950/60 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl">
                                        {{ $project->category?->name
                                            ?: 'Technical Project' }}
                                    </span>

                                    @if ($project->is_featured)
                                        <span class="rounded-full border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-slate-900 dark:text-white backdrop-blur-xl">
                                            Featured
                                        </span>
                                    @endif
                                </div>

                                <h3 class="mt-4 max-w-3xl text-3xl font-black tracking-[-0.025em] text-slate-900 dark:text-white sm:text-4xl">
                                    {{ $project->title }}
                                </h3>

                                <p class="mt-4 max-w-2xl line-clamp-2 text-sm leading-7 text-slate-700 dark:text-slate-300">
                                    {{ $project->short_description
                                        ?: 'A practical engineering and technology project developed around real technical requirements.' }}
                                </p>

                                <div class="mt-5 flex items-center justify-between">
                                    <div class="flex flex-wrap gap-4 text-xs font-bold text-slate-600 dark:text-slate-400">
                                        @if ($project->client_name)
                                            <span>
                                                Client:
                                                {{ $project->client_name }}
                                            </span>
                                        @endif

                                        @if ($project->location)
                                            <span>
                                                {{ $project->location }}
                                            </span>
                                        @endif
                                    </div>

                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-slate-200 dark:border-white/15 bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white backdrop-blur-xl transition group-hover:border-brand-primary/30 group-hover:bg-brand-primary/15 group-hover:text-brand-primary-dark dark:group-hover:text-brand-primary-light">
                                        →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    @foreach ($fallbackProjects as $fallbackProject)
                        <article
                            class="relative overflow-hidden rounded-[2.2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-8"
                            data-reveal="up"
                        >
                            <div class="absolute -right-20 -top-20 h-52 w-52 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <div class="flex items-center justify-between">
                                    <span class="rounded-full border border-brand-primary/20 bg-brand-primary/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light">
                                        {{ $fallbackProject['category'] }}
                                    </span>

                                    <span class="text-5xl font-black text-slate-200 dark:text-white/[0.04]">
                                        {{ str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                    </span>
                                </div>

                                <h3 class="mt-12 text-3xl font-black tracking-[-0.025em] text-slate-900 dark:text-white">
                                    {{ $fallbackProject['title'] }}
                                </h3>

                                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $fallbackProject['description'] }}
                                </p>

                                <div class="mt-10 border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        Project capability
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            @if ($projects->hasPages())
                <div class="mt-12">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    @if (!$ctaSection || $ctaSection->is_active)
        <section class="relative overflow-hidden bg-white dark:bg-slate-950 py-28">
            <div class="pointer-events-none absolute -bottom-32 left-1/3 h-96 w-96 rounded-full bg-brand-secondary/[0.08] blur-[140px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="relative overflow-hidden rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12 lg:p-16"
                    data-reveal="scale"
                >
                    <div
                        class="absolute inset-0 opacity-[0.045] text-slate-900 dark:text-white"
                        style="
                            background-image:
                            linear-gradient(currentColor 1px, transparent 1px),
                            linear-gradient(90deg, currentColor 1px, transparent 1px);
                            background-size: 42px 42px;
                        "
                    ></div>

                    <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-primary/10 blur-[90px]"></div>

                    <div class="relative flex flex-col justify-between gap-10 lg:flex-row lg:items-center">
                        <div class="max-w-3xl">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                                {{ $ctaSection?->subtitle
                                    ?: 'Start a Project' }}
                            </p>

                            <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $ctaSection?->title
                                    ?: 'Have a challenge that needs a practical technical solution?' }}
                            </h2>

                            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $ctaSection?->content
                                    ?: 'Share your project objectives, technical challenge, expected results, and timeline with our team.' }}
                            </p>
                        </div>

                        @if ($ctaButtonText && $ctaButtonUrl)
                            <a
                                href="{{ $ctaButtonUrl }}"
                                class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                            >
                                {{ $ctaButtonText }}

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
