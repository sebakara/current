@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('manufacturing-hero');
    $introSection = $sections->get('manufacturing-intro');
    $capabilitiesSection = $sections->get('manufacturing-capabilities');
    $processSection = $sections->get('manufacturing-process');
    $industriesSection = $sections->get('manufacturing-industries');
    $ctaSection = $sections->get('manufacturing-cta');

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Start a Manufacturing Project'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        route('contact')
    );

    $heroSecondaryText = data_get(
        $heroSection?->data,
        'secondary_button_text',
        'Explore Our Services'
    );

    $heroSecondaryUrl = data_get(
        $heroSection?->data,
        'secondary_button_url',
        route('services.index')
    );

    $capabilities = collect(
        data_get($capabilitiesSection?->data, 'items', [])
    );

    if ($capabilities->isEmpty()) {
        $capabilities = collect([
            [
                'title' => '3D Printing',
                'description' => 'Rapid production of prototypes, models, customized parts, and functional components.',
            ],
            [
                'title' => 'Laser Cutting',
                'description' => 'Precision cutting and engraving for engineering, architectural, and creative applications.',
            ],
            [
                'title' => 'PCB Production',
                'description' => 'Circuit-board design, prototyping, assembly support, testing, and production preparation.',
            ],
            [
                'title' => 'CNC & Machining',
                'description' => 'Precision manufacturing support for mechanical and industrial components.',
            ],
            [
                'title' => 'Product Assembly',
                'description' => 'Integration of mechanical, electronic, enclosure, and finishing components.',
            ],
            [
                'title' => 'Production Consulting',
                'description' => 'Material selection, process planning, cost review, and production-readiness support.',
            ],
        ]);
    }

    $processSteps = collect(
        data_get($processSection?->data, 'items', [])
    );

    if ($processSteps->isEmpty()) {
        $processSteps = collect([
            [
                'number' => '01',
                'title' => 'Requirements',
                'description' => 'We define the product objectives, materials, quantities, timeline, and technical requirements.',
            ],
            [
                'number' => '02',
                'title' => 'Design Review',
                'description' => 'Drawings, models, schematics, tolerances, and production considerations are reviewed.',
            ],
            [
                'number' => '03',
                'title' => 'Prototype',
                'description' => 'A test version is manufactured to validate dimensions, function, fit, and usability.',
            ],
            [
                'number' => '04',
                'title' => 'Testing',
                'description' => 'The prototype is evaluated and necessary improvements are incorporated.',
            ],
            [
                'number' => '05',
                'title' => 'Production',
                'description' => 'Approved designs move to fabrication, assembly, finishing, and quality inspection.',
            ],
        ]);
    }

    $industries = collect(
        data_get($industriesSection?->data, 'items', [])
    );

    if ($industries->isEmpty()) {
        $industries = collect([
            'Education & Research',
            'Electronics & IoT',
            'Agriculture',
            'Construction',
            'Furniture & Interiors',
            'Healthcare Technology',
            'Renewable Energy',
            'Industrial Operations',
        ]);
    }

    $ctaButtonText = data_get(
        $ctaSection?->data,
        'button_text',
        'Request Manufacturing Support'
    );

    $ctaButtonUrl = data_get(
        $ctaSection?->data,
        'button_url',
        route('contact')
    );
@endphp

@section(
    'title',
    $page?->meta_title ?: 'Manufacturing & Digital Fabrication'
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Explore product development, prototyping, machining, PCB production, 3D printing, laser cutting, and manufacturing support.'
)

@section('content')
    {{-- Hero --}}
    <section
        class="relative min-h-[760px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950"
        data-hero-motion
    >
        @if (
            $heroSection?->image
            && Storage::disk('public')->exists($heroSection->image)
        )
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($heroSection->image) }}"
                    alt="{{ $heroSection->title ?: 'Manufacturing' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/60 dark:bg-slate-950/60"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/30 dark:to-slate-950/30"></div>
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

        <div class="relative mx-auto grid min-h-[760px] max-w-7xl items-center gap-14 px-4 py-24 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
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
                        ?: 'Manufacturing & Fabrication' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.1rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'From concept to production-ready solutions.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'We combine engineering, prototyping, digital fabrication, electronics, and production support to help clients transform ideas into functional products.' }}
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

            <div class="relative hidden min-h-[530px] lg:block" data-hero-reveal>
                <div
                    class="absolute inset-3 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl backdrop-blur-2xl"
                    data-motion-layer="14"
                ></div>

                <div
                    class="absolute inset-9 overflow-hidden rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/75 p-6"
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

                    <div class="relative grid h-full grid-cols-2 gap-4">
                        @foreach ($capabilities->take(4) as $capability)
                            <div
                                class="rounded-[1.6rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] p-5"
                                data-service-card
                            >
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-primary/10">
                                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary shadow-[0_0_20px_rgba(34,211,238,.75)]"></span>
                                </div>

                                <h3 class="mt-7 text-lg font-black text-slate-900 dark:text-white">
                                    {{ data_get(
                                        $capability,
                                        'title',
                                        'Manufacturing'
                                    ) }}
                                </h3>

                                <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-500">
                                    {{ data_get(
                                        $capability,
                                        'description',
                                        'Professional manufacturing capability.'
                                    ) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div
                    class="absolute -left-3 top-16 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="34"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        R&amp;D
                    </p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Prototype Ready
                    </p>
                </div>

                <div
                    class="absolute -bottom-1 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="-28"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        01–∞
                    </p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Flexible Quantity
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Introduction --}}
    @if (!$introSection || $introSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-28">
            <div class="pointer-events-none absolute -right-32 top-10 h-96 w-96 rounded-full bg-brand-secondary/[0.06] blur-[130px]"></div>

            <div class="mx-auto grid max-w-7xl gap-14 px-4 sm:px-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-center lg:px-8">
                <div data-reveal="left">
                    <div class="flex items-center gap-4">
                        <span class="h-px w-12 bg-brand-primary"></span>

                        <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                            {{ $introSection?->subtitle
                                ?: 'What We Manufacture' }}
                        </p>
                    </div>

                    <h2 class="mt-6 text-4xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $introSection?->title
                            ?: 'Integrated manufacturing support for every development stage.' }}
                    </h2>

                    <p class="mt-7 text-base leading-8 text-slate-600 dark:text-slate-400">
                        {{ $introSection?->content
                            ?: 'Our capabilities support early prototypes, customized technical parts, electronic products, enclosures, mechanical components, demonstration models, and production preparation.' }}
                    </p>
                </div>

                <div class="relative" data-reveal="right">
                    @if (
                        $introSection?->image
                        && Storage::disk('public')->exists($introSection->image)
                    )
                        <div class="overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10">
                            <img
                                src="{{ Storage::url($introSection->image) }}"
                                alt="{{ $introSection->title ?: 'Manufacturing' }}"
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
                                    Manufacturing Workflow
                                </p>

                                <div class="space-y-4">
                                    @foreach ([
                                        'Design',
                                        'Prototype',
                                        'Test',
                                        'Produce',
                                    ] as $stage)
                                        <div class="flex items-center gap-5 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-5">
                                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-primary/10 text-xs font-black text-brand-primary-dark dark:text-brand-primary-light">
                                                {{ str_pad(
                                                    $loop->iteration,
                                                    2,
                                                    '0',
                                                    STR_PAD_LEFT
                                                ) }}
                                            </span>

                                            <span class="text-xl font-black text-slate-900 dark:text-white">
                                                {{ $stage }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    {{-- Capabilities --}}
    @if (!$capabilitiesSection || $capabilitiesSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="pointer-events-none absolute -left-32 top-1/3 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-end" data-reveal="up">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                            {{ $capabilitiesSection?->subtitle
                                ?: 'Core Capabilities' }}
                        </p>

                        <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                            {{ $capabilitiesSection?->title
                                ?: 'Modern tools for practical production.' }}
                        </h2>
                    </div>

                    <p class="max-w-lg text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $capabilitiesSection?->content
                            ?: 'We select the appropriate manufacturing method according to material, precision, quantity, timeline, and intended use.' }}
                    </p>
                </div>

                <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($capabilities as $capability)
                        <article
                            class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 transition hover:-translate-y-2 hover:border-brand-primary/25"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <div class="flex items-center justify-between">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10">
                                        <span class="h-3 w-3 rounded-full bg-brand-primary shadow-[0_0_22px_rgba(34,211,238,.8)]"></span>
                                    </div>

                                    <span class="text-5xl font-black text-slate-200 dark:text-white/[0.04]">
                                        {{ str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                    </span>
                                </div>

                                <h3 class="mt-8 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ data_get(
                                        $capability,
                                        'title',
                                        'Manufacturing Capability'
                                    ) }}
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ data_get(
                                        $capability,
                                        'description',
                                        'Professional production support tailored to technical requirements.'
                                    ) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Dynamic manufacturing services --}}
    @if ($manufacturingServices->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6" data-reveal="up">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                            Available Services
                        </p>

                        <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                            Manufacturing services
                        </h2>
                    </div>

                    <a
                        href="{{ route('services.index') }}"
                        class="hidden text-sm font-black text-brand-primary sm:inline-flex"
                    >
                        View All Services →
                    </a>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($manufacturingServices as $service)
                        <a
                            href="{{ route('services.show', $service) }}"
                            class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition hover:-translate-y-2 hover:border-brand-primary/25"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="relative h-60 overflow-hidden">
                                @if (
                                    $service->featured_image
                                    && Storage::disk('public')->exists(
                                        $service->featured_image
                                    )
                                )
                                    <img
                                        src="{{ Storage::url(
                                            $service->featured_image
                                        ) }}"
                                        alt="{{ $service->title }}"
                                        class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                    >

                                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>
                                @else
                                    <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10">
                                        <span class="text-6xl font-black text-slate-200 dark:text-white/10">
                                            {{ strtoupper(substr(
                                                $service->title ?: 'VT',
                                                0,
                                                2
                                            )) }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-7">
                                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                    {{ $service->category?->name
                                        ?: 'Manufacturing' }}
                                </p>

                                <h3 class="mt-3 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $service->title }}
                                </h3>

                                <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $service->short_description
                                        ?: 'Professional manufacturing service tailored to your project requirements.' }}
                                </p>

                                <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        View Service
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

    {{-- Process --}}
    @if (!$processSection || $processSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-3xl text-center" data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $processSection?->subtitle ?: 'Our Process' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $processSection?->title
                            ?: 'A structured path from idea to finished product.' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        {{ $processSection?->content
                            ?: 'Every manufacturing project follows a workflow designed to reduce uncertainty, improve quality, and support reliable delivery.' }}
                    </p>
                </div>

                <div class="relative mt-16">
                    <div class="absolute left-6 top-0 hidden h-px w-[calc(100%-3rem)] bg-gradient-to-r from-brand-primary via-brand-secondary to-brand-primary lg:block"></div>

                    <div class="grid gap-5 lg:grid-cols-5">
                        @foreach ($processSteps as $step)
                            <article
                                class="relative rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-6"
                                data-reveal="up"
                            >
                                <div class="relative z-10 flex h-12 w-12 items-center justify-center rounded-2xl border border-brand-primary/20 bg-white dark:bg-slate-950 text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                    {{ data_get(
                                        $step,
                                        'number',
                                        str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        )
                                    ) }}
                                </div>

                                <h3 class="mt-7 text-xl font-black text-slate-900 dark:text-white">
                                    {{ data_get(
                                        $step,
                                        'title',
                                        'Process Stage'
                                    ) }}
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ data_get(
                                        $step,
                                        'description',
                                        'An important stage in the manufacturing process.'
                                    ) }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Industries --}}
    @if (!$industriesSection || $industriesSection->is_active)
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:items-center lg:px-8">
                <div data-reveal="left">
                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $industriesSection?->subtitle
                            ?: 'Industries We Serve' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $industriesSection?->title
                            ?: 'Manufacturing support across multiple sectors.' }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        {{ $industriesSection?->content
                            ?: 'Our flexible technical capabilities allow us to support institutions, innovators, startups, businesses, and industrial operators.' }}
                    </p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2" data-reveal="right">
                    @foreach ($industries as $industry)
                        <div class="group flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-5 transition hover:border-brand-primary/20 hover:bg-brand-primary/[0.04]">
                            <span class="font-black text-slate-900 dark:text-white">
                                {{ is_array($industry)
                                    ? data_get($industry, 'title', 'Industry')
                                    : $industry }}
                            </span>

                            <span class="text-brand-primary transition group-hover:translate-x-1">
                                →
                            </span>
                        </div>
                    @endforeach
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
                                {{ $ctaSection?->subtitle ?: 'Start Production' }}
                            </p>

                            <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $ctaSection?->title
                                    ?: 'Ready to manufacture your next idea?' }}
                            </h2>

                            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $ctaSection?->content
                                    ?: 'Send us your concept, drawing, sample, specification, or problem statement so our team can recommend the right production approach.' }}
                            </p>
                        </div>

                        @if ($ctaButtonText && $ctaButtonUrl)
                            <a
                                href="{{ $ctaButtonUrl }}"
                                class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                            >
                                {{ $ctaButtonText }}
                                <span class="transition group-hover:translate-x-1">→</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
