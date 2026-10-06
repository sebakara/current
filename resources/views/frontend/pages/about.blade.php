@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('about-hero');
    $storySection = $sections->get('company-story');
    $missionSection = $sections->get('mission-vision');
    $valuesSection = $sections->get('core-values');
    $teamSection = $sections->get('team');
    $achievementsSection = $sections->get('achievements');
    $timelineSection = $sections->get('timeline');
    $ctaSection = $sections->get('about-cta');

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Explore Our Services'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        route('services.index')
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

    $missionTitle = data_get(
        $missionSection?->data,
        'mission_title',
        'Our Mission'
    );

    $missionText = data_get(
        $missionSection?->data,
        'mission_text',
        'To provide accessible engineering, manufacturing, technology, and practical training solutions that transform ideas into useful products, systems, and skills.'
    );

    $visionTitle = data_get(
        $missionSection?->data,
        'vision_title',
        'Our Vision'
    );

    $visionText = data_get(
        $missionSection?->data,
        'vision_text',
        'To become a leading innovation and technical development laboratory supporting industrial growth, entrepreneurship, education, and technological progress.'
    );

    $fallbackValues = collect([
        [
            'title' => 'Innovation',
            'description' => 'We transform creative ideas into functional and valuable solutions.',
        ],
        [
            'title' => 'Practicality',
            'description' => 'We focus on solutions that work in real environments.',
        ],
        [
            'title' => 'Quality',
            'description' => 'We value accuracy, testing, reliability, and continuous improvement.',
        ],
        [
            'title' => 'Collaboration',
            'description' => 'We work closely with clients, learners, institutions, and partners.',
        ],
        [
            'title' => 'Learning',
            'description' => 'We share knowledge and support the development of future innovators.',
        ],
        [
            'title' => 'Responsibility',
            'description' => 'We respect commitments and consider the long-term impact of our work.',
        ],
    ]);

    $values = collect(
        data_get($valuesSection?->data, 'items', [])
    );

    if ($values->isEmpty()) {
        $values = $fallbackValues;
    }

    $achievementItems = collect(
        data_get($achievementsSection?->data, 'items', [])
    );

    if ($achievementItems->isEmpty()) {
        $achievementItems = collect([
            [
                'value' => '10',
                'suffix' => '+',
                'label' => 'Technical Capabilities',
            ],
            [
                'value' => '50',
                'suffix' => '+',
                'label' => 'Projects Supported',
            ],
            [
                'value' => '100',
                'suffix' => '+',
                'label' => 'Learners Reached',
            ],
            [
                'value' => '360',
                'suffix' => '°',
                'label' => 'Development Support',
            ],
        ]);
    }

    $timelineItems = collect(
        data_get($timelineSection?->data, 'items', [])
    );

    if ($timelineItems->isEmpty()) {
        $timelineItems = collect([
            [
                'year' => 'Foundation',
                'title' => 'The idea takes shape',
                'description' => 'A platform is established to connect technical knowledge with practical implementation.',
            ],
            [
                'year' => 'Expansion',
                'title' => 'Capabilities grow',
                'description' => 'Engineering, manufacturing, fabrication, consulting, and software services expand.',
            ],
            [
                'year' => 'Academy',
                'title' => 'Practical training launches',
                'description' => 'Hands-on technical learning becomes part of the innovation ecosystem.',
            ],
            [
                'year' => 'Future',
                'title' => 'Building industrial impact',
                'description' => 'Research, products, production, and partnerships continue to develop.',
            ],
        ]);
    }

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
@endphp

@section(
    'title',
    $page?->meta_title ?: 'About Us'
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Learn about our mission, vision, engineering capabilities, team, values, achievements, and growth.'
)

@section('content')
    {{-- Hero --}}
    <section
        class="relative min-h-[720px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950"
        data-hero-motion
    >
        @if (
            $heroSection?->image
            && Storage::disk('public')->exists($heroSection->image)
        )
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($heroSection->image) }}"
                    alt="{{ $heroSection->title ?: 'About Us' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/30 dark:to-slate-950/30"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/35 dark:to-slate-950/35"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0 overflow-hidden">
                <div
                    class="absolute -left-40 top-10 h-[32rem] w-[32rem] rounded-full bg-brand-primary-dark/10 blur-[140px]"
                    data-motion-layer="20"
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

        <div class="relative mx-auto grid min-h-[720px] max-w-7xl items-center gap-14 px-4 py-24 sm:px-6 lg:grid-cols-[1.08fr_0.92fr] lg:px-8">
            <div>
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-brand-primary/20 bg-brand-primary/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl"
                    data-hero-reveal
                >
                    <span class="h-2 w-2 rounded-full bg-brand-primary"></span>

                    {{ $heroSection?->subtitle ?: 'About Our Company' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.3rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Engineering innovation for practical impact.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'We connect engineering knowledge, digital fabrication, manufacturing, software, consulting, and practical education to help ideas become useful solutions.' }}
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
                            <span class="transition group-hover:translate-x-1">→</span>
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

            <div class="relative hidden min-h-[500px] lg:block" data-hero-reveal>
                <div
                    class="absolute inset-4 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.065] to-white dark:to-white/[0.015] shadow-2xl shadow-slate-300/50 dark:shadow-black/40 backdrop-blur-2xl"
                    data-motion-layer="16"
                ></div>

                <div
                    class="absolute inset-10 overflow-hidden rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                    data-motion-layer="24"
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
                                Integrated Capability
                            </p>

                            <h2 class="mt-5 text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                From concept to implementation.
                            </h2>

                            <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-400">
                                Research, design, fabrication, manufacturing,
                                software, consulting, and training work together
                                within one technical ecosystem.
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            @foreach ([
                                'Engineering',
                                'Manufacturing',
                                'Technology',
                                'Training',
                            ] as $capability)
                                <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-4">
                                    <span class="h-2 w-2 rounded-full bg-brand-primary"></span>

                                    <p class="mt-5 text-sm font-black text-slate-900 dark:text-white">
                                        {{ $capability }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="absolute -left-3 top-20 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/85 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="36"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">R&amp;D</p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Innovation Driven
                    </p>
                </div>

                <div
                    class="absolute -bottom-1 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/85 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="-30"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">360°</p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Technical Support
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Story --}}
    @if (!$storySection || $storySection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-28">
            <div class="pointer-events-none absolute -right-32 top-16 h-96 w-96 rounded-full bg-brand-secondary/[0.06] blur-[130px]"></div>

            <div class="mx-auto grid max-w-7xl gap-14 px-4 sm:px-6 lg:grid-cols-[0.85fr_1.15fr] lg:items-center lg:px-8">
                <div data-reveal="left">
                    <div class="flex items-center gap-4">
                        <span class="h-px w-12 bg-brand-primary"></span>

                        <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                            {{ $storySection?->subtitle ?: 'Our Story' }}
                        </p>
                    </div>

                    <h2 class="mt-6 text-4xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $storySection?->title
                            ?: 'Built to close the gap between ideas and implementation.' }}
                    </h2>

                    <p class="mt-7 text-base leading-8 text-slate-600 dark:text-slate-400">
                        {{ $storySection?->content
                            ?: 'We created a technical environment where ideas can be designed, tested, manufactured, improved, and transformed into useful products and systems.' }}
                    </p>
                </div>

                <div class="relative" data-reveal="right">
                    @if (
                        $storySection?->image
                        && Storage::disk('public')->exists($storySection->image)
                    )
                        <div class="overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10">
                            <img
                                src="{{ Storage::url($storySection->image) }}"
                                alt="{{ $storySection->title ?: 'Our Story' }}"
                                class="h-[500px] w-full object-cover"
                            >
                        </div>
                    @else
                        <div class="relative min-h-[500px] overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8">
                            <div
                                class="absolute inset-0 opacity-[0.06] text-slate-900 dark:text-white"
                                style="
                                    background-image:
                                    linear-gradient(currentColor 1px, transparent 1px),
                                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                                    background-size: 40px 40px;
                                "
                            ></div>

                            <div class="relative flex min-h-[436px] flex-col justify-between">
                                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                    {{ data_get(
                                        $storySection?->data,
                                        'highlight_title',
                                        'One Innovation Ecosystem'
                                    ) }}
                                </p>

                                <div>
                                    <p class="text-5xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-6xl">
                                        Idea
                                    </p>

                                    <div class="my-4 h-px bg-gradient-to-r from-brand-primary to-transparent"></div>

                                    <p class="text-5xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-6xl">
                                        Design
                                    </p>

                                    <div class="my-4 h-px bg-gradient-to-r from-brand-secondary to-transparent"></div>

                                    <p class="text-5xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-6xl">
                                        Reality
                                    </p>
                                </div>

                                <p class="max-w-md text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    {{ data_get(
                                        $storySection?->data,
                                        'highlight_text',
                                        'Design, engineering, manufacturing, technology, and training under one platform.'
                                    ) }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Mission and Vision --}}
    @if (!$missionSection || $missionSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center" data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $missionSection?->subtitle ?: 'Mission & Vision' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $missionSection?->title
                            ?: 'Purpose that guides every project.' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        {{ $missionSection?->content
                            ?: 'Our direction is shaped by practical innovation, capability development, and long-term technical impact.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-6 lg:grid-cols-2">
                    <article
                        class="group relative overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-8 sm:p-10"
                        data-reveal="left"
                    >
                        <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full bg-brand-primary/[0.08] blur-[90px]"></div>

                        <div class="relative">
                            <span class="text-7xl font-black text-slate-200 dark:text-white/[0.04]">
                                01
                            </span>

                            <p class="mt-8 text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                Mission
                            </p>

                            <h3 class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                                {{ $missionTitle }}
                            </h3>

                            <p class="mt-6 text-base leading-8 text-slate-600 dark:text-slate-400">
                                {{ $missionText }}
                            </p>
                        </div>
                    </article>

                    <article
                        class="group relative overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-8 sm:p-10"
                        data-reveal="right"
                    >
                        <div class="absolute -left-24 -bottom-24 h-64 w-64 rounded-full bg-brand-secondary/[0.08] blur-[90px]"></div>

                        <div class="relative">
                            <span class="text-7xl font-black text-slate-200 dark:text-white/[0.04]">
                                02
                            </span>

                            <p class="mt-8 text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                Vision
                            </p>

                            <h3 class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                                {{ $visionTitle }}
                            </h3>

                            <p class="mt-6 text-base leading-8 text-slate-600 dark:text-slate-400">
                                {{ $visionText }}
                            </p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    @endif

    {{-- Core values --}}
    @if (!$valuesSection || $valuesSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-28">
            <div class="pointer-events-none absolute -left-32 top-1/3 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end" data-reveal="up">
                    <div class="max-w-3xl">
                        <div class="flex items-center gap-4">
                            <span class="h-px w-12 bg-brand-primary"></span>

                            <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                                {{ $valuesSection?->subtitle ?: 'Core Values' }}
                            </p>
                        </div>

                        <h2 class="mt-6 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                            {{ $valuesSection?->title
                                ?: 'The principles behind our work.' }}
                        </h2>
                    </div>

                    <p class="max-w-lg text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $valuesSection?->content
                            ?: 'Every solution is developed around quality, practicality, learning, responsibility, and measurable value.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($values as $value)
                        <article
                            class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.025] p-7 transition hover:-translate-y-2 hover:border-brand-primary/25 hover:bg-brand-primary/[0.04]"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10">
                                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary shadow-[0_0_20px_rgba(34,211,238,.75)]"></span>
                                </div>

                                <h3 class="mt-8 text-xl font-black text-slate-900 dark:text-white">
                                    {{ data_get($value, 'title', 'Core Value') }}
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ data_get(
                                        $value,
                                        'description',
                                        'A principle that guides our work and relationships.'
                                    ) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Team --}}
    @if (!$teamSection || $teamSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center" data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $teamSection?->subtitle ?: 'Our Team' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $teamSection?->title
                            ?: 'The people behind the innovation.' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        {{ $teamSection?->content
                            ?: 'Our multidisciplinary team combines engineering, fabrication, software, training, research, and project management.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @forelse ($teamMembers as $member)
                        <article
                            class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition hover:-translate-y-2 hover:border-brand-primary/25"
                            data-reveal="up"
                        >
                            <div class="relative h-80 overflow-hidden bg-slate-50 dark:bg-slate-900">
                                @if (
                                    $member->photo
                                    && Storage::disk('public')->exists($member->photo)
                                )
                                    <img
                                        src="{{ Storage::url($member->photo) }}"
                                        alt="{{ $member->name }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                    >

                                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10"></div>

                                    <div
                                        class="absolute inset-0 opacity-[0.06] text-slate-900 dark:text-white"
                                        style="
                                            background-image:
                                            linear-gradient(currentColor 1px, transparent 1px),
                                            linear-gradient(90deg, currentColor 1px, transparent 1px);
                                            background-size: 34px 34px;
                                        "
                                    ></div>

                                    <div class="relative flex h-full items-center justify-center">
                                        <span class="text-7xl font-black text-slate-200 dark:text-white/10">
                                            {{ strtoupper(substr(
                                                $member->name ?: 'VT',
                                                0,
                                                2
                                            )) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                    {{ $member->role ?: 'Team Member' }}
                                </p>

                                <h3 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                    {{ $member->name }}
                                </h3>

                                @if ($member->department)
                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                                        {{ $member->department }}
                                    </p>
                                @endif

                                @if ($member->bio)
                                    <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                        {{ $member->bio }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @empty
                        @foreach ([
                            ['name' => 'Engineering Team', 'role' => 'Research & Development'],
                            ['name' => 'Fabrication Team', 'role' => 'Manufacturing & Prototyping'],
                            ['name' => 'Technology Team', 'role' => 'Software & Smart Systems'],
                            ['name' => 'Training Team', 'role' => 'Technical Education'],
                        ] as $fallbackMember)
                            <article
                                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                                data-reveal="up"
                            >
                                <div class="flex h-20 w-20 items-center justify-center rounded-[1.5rem] bg-gradient-to-br from-brand-primary/15 to-brand-secondary/10">
                                    <span class="text-xl font-black text-brand-primary-dark dark:text-brand-primary-light">
                                        {{ strtoupper(substr(
                                            $fallbackMember['name'],
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>

                                <p class="mt-8 text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                    {{ $fallbackMember['role'] }}
                                </p>

                                <h3 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                    {{ $fallbackMember['name'] }}
                                </h3>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    {{-- Achievements --}}
    @if (!$achievementsSection || $achievementsSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-center">
                    <div data-reveal="left">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                            {{ $achievementsSection?->subtitle ?: 'Achievements' }}
                        </p>

                        <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                            {{ $achievementsSection?->title
                                ?: 'Progress measured through capability and impact.' }}
                        </h2>

                        <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                            {{ $achievementsSection?->content
                                ?: 'Our growth is reflected in the solutions delivered, people trained, partnerships developed, and technical capabilities established.' }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4" data-reveal="right">
                        @foreach ($achievementItems as $item)
                            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6 sm:p-8">
                                <p class="text-4xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-5xl">
                                    <span
                                        data-counter="{{ (int) data_get($item, 'value', 0) }}"
                                    >0</span>{{ data_get($item, 'suffix', '') }}
                                </p>

                                <p class="mt-3 text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                    {{ data_get($item, 'label', 'Achievement') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Timeline --}}
    @if (!$timelineSection || $timelineSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center" data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $timelineSection?->subtitle ?: 'Our Journey' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $timelineSection?->title
                            ?: 'A growing platform for engineering and innovation.' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        {{ $timelineSection?->content
                            ?: 'Each stage strengthens our ability to serve more innovators, institutions, businesses, and industries.' }}
                    </p>
                </div>

                <div class="relative mx-auto mt-16 max-w-5xl">
                    <div class="absolute bottom-0 left-5 top-0 w-px bg-gradient-to-b from-brand-primary via-brand-secondary to-transparent md:left-1/2"></div>

                    <div class="space-y-10">
                        @foreach ($timelineItems as $item)
                            <article
                                class="relative grid gap-6 pl-14 md:grid-cols-2 md:pl-0"
                                data-reveal="{{ $loop->odd ? 'left' : 'right' }}"
                            >
                                <span class="absolute left-[14px] top-8 z-10 h-3 w-3 rounded-full bg-brand-primary shadow-[0_0_20px_rgba(34,211,238,.8)] md:left-1/2 md:-translate-x-1/2"></span>

                                <div class="{{ $loop->even ? 'md:col-start-2' : '' }}">
                                    <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7">
                                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                            {{ data_get($item, 'year', 'Milestone') }}
                                        </p>

                                        <h3 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                                            {{ data_get(
                                                $item,
                                                'title',
                                                'Company Milestone'
                                            ) }}
                                        </h3>

                                        <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                            {{ data_get(
                                                $item,
                                                'description',
                                                'An important stage in the growth of our innovation platform.'
                                            ) }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

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
                                {{ $ctaSection?->subtitle ?: 'Work With Us' }}
                            </p>

                            <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $ctaSection?->title
                                    ?: 'Let’s create something practical, valuable, and built to last.' }}
                            </h2>

                            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $ctaSection?->content
                                    ?: 'Whether you need product development, manufacturing, technical consulting, software, or training, our team is ready to understand your goals.' }}
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
