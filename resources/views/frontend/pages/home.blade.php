@extends('frontend.layouts.app')

@php
    /*
    |--------------------------------------------------------------------------
    | Dynamic CMS content with safe fallbacks
    |--------------------------------------------------------------------------
    */

    $displayHeroSlides = $heroSlides->isNotEmpty()
        ? $heroSlides
        : collect([
            (object) [
                'eyebrow' => 'Build. Manufacture. Innovate.',
                'title' => 'Engineering ideas into practical solutions.',
                'description' => 'We combine engineering, advanced manufacturing, digital fabrication, software development, consulting, and practical technical training.',
                'background_image' => null,
                'mobile_image' => null,
                'primary_button_text' => 'Explore Our Services',
                'primary_button_url' => route('services.index'),
                'secondary_button_text' => 'Discuss Your Project',
                'secondary_button_url' => route('contact'),
                'text_position' => 'left',
            ],
        ]);

    $aboutSection = $sections->get('about-preview');
    $servicesSection = $sections->get('services');
    $projectCtaSection = $sections->get('project-cta');

    $aboutButtonText = data_get(
        $aboutSection?->data,
        'button_text',
        'Discover Our Story'
    );

    $aboutButtonUrl = data_get(
        $aboutSection?->data,
        'button_url',
        route('about')
    );

    $servicesButtonText = data_get(
        $servicesSection?->data,
        'button_text',
        'View All Services'
    );

    $servicesButtonUrl = data_get(
        $servicesSection?->data,
        'button_url',
        route('services.index')
    );

    $ctaButtonText = data_get(
        $projectCtaSection?->data,
        'button_text',
        'Request a Consultation'
    );

    $ctaButtonUrl = data_get(
        $projectCtaSection?->data,
        'button_url',
        route('contact')
    );

    $fallbackServices = collect([
        [
            'title' => 'Advanced Manufacturing',
            'description' => 'Prototype development, technical fabrication, and production support.',
        ],
        [
            'title' => 'PCB Design',
            'description' => 'Circuit design, board prototyping, testing, and production preparation.',
        ],
        [
            'title' => '3D Printing',
            'description' => 'Rapid prototyping and custom additive manufacturing solutions.',
        ],
        [
            'title' => 'Laser Cutting',
            'description' => 'Precision fabrication for engineering and creative applications.',
        ],
        [
            'title' => 'Smart Laboratory Setup',
            'description' => 'Planning and implementation of complete technical laboratories.',
        ],
        [
            'title' => 'Industrial Consulting',
            'description' => 'Practical engineering guidance for operational and production challenges.',
        ],
    ]);

    $fallbackCapabilities = collect([
        [
            'title' => 'PCB Engineering',
            'description' => 'From electronic schematic to functional board.',
        ],
        [
            'title' => 'Digital Fabrication',
            'description' => '3D printing, laser cutting, and precision prototyping.',
        ],
        [
            'title' => 'Smart Laboratories',
            'description' => 'Complete technical laboratory design and implementation.',
        ],
        [
            'title' => 'Industrial Solutions',
            'description' => 'Engineering systems for real operational challenges.',
        ],
    ]);
@endphp

@section(
    'title',
    $page?->meta_title
        ?: setting(
            'default_meta_title',
            'Innovation, Manufacturing & Technology'
        )
)

@section(
    'meta_description',
    $page?->meta_description
        ?: setting(
            'default_meta_description',
            'Engineering, manufacturing, digital fabrication, software, and technical training solutions.'
        )
)

@section('content')
    {{-- ================================================================ --}}
    {{-- HERO                                                             --}}
    {{-- ================================================================ --}}

    <section
        class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950"
        data-hero-motion
    >
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div
                class="absolute -left-40 top-20 h-[30rem] w-[30rem] rounded-full bg-brand-primary-dark/10 blur-[130px]"
                data-motion-layer="18"
            ></div>

            <div
                class="absolute -right-40 top-0 h-[34rem] w-[34rem] rounded-full bg-brand-secondary/10 blur-[150px]"
                data-motion-layer="-24"
            ></div>

            <div
                class="absolute bottom-0 left-1/3 h-72 w-72 rounded-full bg-violet-600/[0.07] blur-[120px]"
                data-motion-layer="12"
            ></div>

            <div
                class="absolute inset-0 opacity-[0.035] text-slate-900 dark:text-white"
                style="
                    background-image:
                    linear-gradient(currentColor 1px, transparent 1px),
                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                    background-size: 56px 56px;
                "
            ></div>

            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-white/75 dark:to-slate-950/75"></div>
        </div>

        <div class="swiper vtlabs-hero-slider relative">
            <div class="swiper-wrapper">
                @foreach ($displayHeroSlides as $slide)
                    @php
                        $slideEyebrow = $slide->eyebrow
                            ?: 'Build. Manufacture. Innovate.';

                        $slideTitle = $slide->title
                            ?: 'Engineering ideas into practical solutions.';

                        $slideDescription = $slide->description
                            ?: 'We deliver engineering, manufacturing, technology, consulting, and practical training solutions.';

                        $primaryText = $slide->primary_button_text
                            ?: 'Explore Our Services';

                        $primaryUrl = $slide->primary_button_url
                            ?: route('services.index');

                        $secondaryText = $slide->secondary_button_text
                            ?: 'Discuss Your Project';

                        $secondaryUrl = $slide->secondary_button_url
                            ?: route('contact');

                        $desktopImageExists = !empty($slide->background_image)
                            && Storage::disk('public')->exists(
                                $slide->background_image
                            );

                        $mobileImageExists = !empty($slide->mobile_image)
                            && Storage::disk('public')->exists(
                                $slide->mobile_image
                            );

                        $textPosition = in_array(
                            $slide->text_position,
                            ['left', 'center', 'right'],
                            true
                        )
                            ? $slide->text_position
                            : 'left';
                    @endphp

                    <div class="swiper-slide">
                        <article class="relative min-h-[620px] sm:min-h-[680px] xl:min-h-[740px]">
                            @if ($desktopImageExists)
                                <div class="absolute inset-0 overflow-hidden">
                                    <picture>
                                        @if ($mobileImageExists)
                                            <source
                                                media="(max-width: 767px)"
                                                srcset="{{ Storage::url(
                                                    $slide->mobile_image
                                                ) }}"
                                            >
                                        @endif

                                        <img
                                            src="{{ Storage::url(
                                                $slide->background_image
                                            ) }}"
                                            alt="{{ $slideTitle }}"
                                            class="h-full w-full scale-[1.04] object-cover"
                                            data-motion-layer="-10"
                                        >
                                    </picture>

                                    <div class="absolute inset-0 bg-white/60 dark:bg-slate-950/60"></div>

                                    <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/88 dark:via-slate-950/88 to-white/25 dark:to-slate-950/25"></div>

                                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/30 dark:to-slate-950/30"></div>
                                </div>
                            @endif

                            <div class="relative mx-auto grid min-h-[620px] max-w-7xl items-center gap-10 px-4 py-14 sm:min-h-[680px] sm:px-6 sm:py-16 lg:grid-cols-[1.05fr_0.95fr] lg:gap-12 lg:px-8 xl:min-h-[740px] xl:py-20">
                                <div
                                    class="
                                        {{ $textPosition === 'center'
                                            ? 'mx-auto max-w-4xl text-center lg:col-span-2'
                                            : '' }}

                                        {{ $textPosition === 'right'
                                            ? 'lg:col-start-2'
                                            : '' }}
                                    "
                                >
                                    <div
                                        class="inline-flex items-center gap-3 rounded-full border border-brand-primary/20 bg-brand-primary/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl"
                                        data-hero-reveal
                                    >
                                        <span class="relative flex h-2.5 w-2.5">
                                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-primary opacity-50"></span>

                                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-primary"></span>
                                        </span>

                                        {{ $slideEyebrow }}
                                    </div>

                                    <h1
                                        class="
                                            mt-6 max-w-4xl text-4xl font-black leading-[1.02] tracking-[-0.04em] text-slate-900 dark:text-white
                                            sm:text-5xl lg:text-6xl xl:text-7xl

                                            {{ $textPosition === 'center'
                                                ? 'mx-auto'
                                                : '' }}
                                        "
                                        data-hero-reveal
                                    >
                                        {{ $slideTitle }}
                                    </h1>

                                    <p
                                        class="
                                            mt-5 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg

                                            {{ $textPosition === 'center'
                                                ? 'mx-auto'
                                                : '' }}
                                        "
                                        data-hero-reveal
                                    >
                                        {{ $slideDescription }}
                                    </p>

                                    <div
                                        class="
                                            mt-7 flex flex-col gap-3 sm:flex-row

                                            {{ $textPosition === 'center'
                                                ? 'justify-center'
                                                : '' }}
                                        "
                                        data-hero-reveal
                                    >
                                        @if ($primaryText && $primaryUrl)
                                            <a
                                                href="{{ $primaryUrl }}"
                                                class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white shadow-[0_18px_50px_rgba(34,211,238,0.18)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_22px_65px_rgba(34,211,238,0.28)]"
                                            >
                                                {{ $primaryText }}

                                                <svg
                                                    class="h-4 w-4 transition group-hover:translate-x-1"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="m9 18 6-6-6-6"
                                                    />
                                                </svg>
                                            </a>
                                        @endif

                                        @if ($secondaryText && $secondaryUrl)
                                            <a
                                                href="{{ $secondaryUrl }}"
                                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition duration-300 hover:-translate-y-1 hover:border-slate-300 dark:hover:border-white/20 hover:bg-slate-100 dark:hover:bg-white/[0.085]"
                                            >
                                                {{ $secondaryText }}
                                            </a>
                                        @endif
                                    </div>

                                    <div
                                        class="
                                            mt-12 grid max-w-2xl grid-cols-3 gap-3

                                            {{ $textPosition === 'center'
                                                ? 'mx-auto'
                                                : '' }}
                                        "
                                        data-hero-reveal
                                    >
                                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] p-4 backdrop-blur-xl">
                                            <p class="text-xl font-black text-slate-900 dark:text-white">
                                                {{ $serviceCategories->count() ?: '6+' }}
                                            </p>

                                            <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:text-slate-500 sm:text-[11px]">
                                                Capabilities
                                            </p>
                                        </div>

                                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] p-4 backdrop-blur-xl">
                                            <p class="text-xl font-black text-slate-900 dark:text-white">
                                                {{ $featuredServices->count() ?: '10+' }}
                                            </p>

                                            <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:text-slate-500 sm:text-[11px]">
                                                Solutions
                                            </p>
                                        </div>

                                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] p-4 backdrop-blur-xl">
                                            <p class="text-xl font-black text-slate-900 dark:text-white">
                                                360°
                                            </p>

                                            <p class="mt-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-600 dark:text-slate-500 sm:text-[11px]">
                                                Development
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                @if ($textPosition !== 'center')
                                    <div
                                        class="
                                            relative hidden min-h-[520px] lg:block

                                            {{ $textPosition === 'right'
                                                ? 'lg:col-start-1 lg:row-start-1'
                                                : '' }}
                                        "
                                        data-hero-reveal
                                    >
                                        <div
                                            class="absolute inset-4 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl shadow-slate-300/50 dark:shadow-black/40 backdrop-blur-2xl"
                                            data-motion-layer="14"
                                        ></div>

                                        <div
                                            class="absolute inset-10 overflow-hidden rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/70"
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

                                            <div class="relative grid h-full min-h-0 grid-cols-2 grid-rows-2 gap-4 p-6">
                                                @forelse ($serviceCategories->take(4) as $category)
                                                    <a
                                                        href="{{ route(
                                                            'services.index',
                                                            ['category' => $category->slug]
                                                        ) }}"
                                                        class="group relative min-h-0 overflow-hidden rounded-[1.6rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] p-4 transition duration-300 hover:-translate-y-1 hover:border-brand-primary/30 hover:bg-brand-primary/[0.07]"
                                                        data-service-card
                                                    >
                                                        <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-brand-primary/[0.08] blur-2xl"></div>

                                                        <div class="relative flex h-full min-h-0 flex-col">
                                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border border-brand-primary/10 bg-brand-primary/10">
                                                                <span class="h-2.5 w-2.5 rounded-full bg-brand-primary shadow-[0_0_20px_rgba(34,211,238,0.7)]"></span>
                                                            </div>

                                                            <h3 class="mt-3 text-base font-black leading-6 text-slate-900 dark:text-white">
                                                                {{ $category->name }}
                                                            </h3>

                                                            <p class="mt-2 line-clamp-1 text-sm leading-5 text-slate-600 dark:text-slate-500">
                                                                {{ $category->description
                                                                    ?: $category->services_count . ' available services' }}
                                                            </p>

                                                            <div class="mt-auto flex items-center justify-between pt-2 text-xs font-bold text-brand-primary">
                                                                <span>Explore</span>

                                                                <span class="transition group-hover:translate-x-1">
                                                                    →
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @empty
                                                    @foreach ($fallbackCapabilities as $capability)
                                                        <div
                                                            class="relative min-h-0 overflow-hidden rounded-[1.6rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] p-4"
                                                            data-service-card
                                                        >
                                                            <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-brand-primary/[0.08] blur-2xl"></div>

                                                            <div class="relative flex h-full min-h-0 flex-col">
                                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-brand-primary/10 bg-brand-primary/10">
                                                                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary shadow-[0_0_20px_rgba(34,211,238,0.7)]"></span>
                                                                </div>

                                                                <h3 class="mt-4 text-base font-black leading-6 text-slate-900 dark:text-white">
                                                                    {{ $capability['title'] }}
                                                                </h3>

                                                                <p class="mt-2 line-clamp-2 text-sm leading-5 text-slate-600 dark:text-slate-500">
                                                                    {{ $capability['description'] }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endforelse
                                            </div>
                                        </div>

                                        <div
                                            class="absolute -left-2 top-16 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/85 px-4 py-3 shadow-xl backdrop-blur-xl"
                                            data-motion-layer="34"
                                        >
                                            <p class="text-[10px] font-black uppercase tracking-[0.18em] text-slate-600 dark:text-slate-500">
                                                Innovation Status
                                            </p>

                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>

                                                <span class="text-xs font-bold text-slate-900 dark:text-white">
                                                    Laboratory Active
                                                </span>
                                            </div>
                                        </div>

                                        <div
                                            class="absolute -bottom-1 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/85 px-5 py-4 shadow-xl backdrop-blur-xl"
                                            data-motion-layer="-30"
                                        >
                                            <p class="text-2xl font-black text-slate-900 dark:text-white">
                                                R&amp;D
                                            </p>

                                            <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                                                Concept to Reality
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </article>
                    </div>
                @endforeach
            </div>

            <div class="pointer-events-none absolute inset-x-0 bottom-8 z-20">
                <div class="mx-auto flex max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                    <div class="vtlabs-hero-pagination pointer-events-auto !static !w-auto"></div>

                    @if ($displayHeroSlides->count() > 1)
                        <div class="pointer-events-auto flex items-center gap-2">
                            <button
                                type="button"
                                class="vtlabs-hero-prev flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 dark:border-white/10 bg-white/50 dark:bg-slate-950/50 text-slate-900 dark:text-white backdrop-blur-xl transition hover:border-brand-primary/30 hover:bg-brand-primary/10 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                            >
                                <span class="sr-only">Previous slide</span>

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m15 18-6-6 6-6"
                                    />
                                </svg>
                            </button>

                            <button
                                type="button"
                                class="vtlabs-hero-next flex h-11 w-11 items-center justify-center rounded-full border border-slate-200 dark:border-white/10 bg-white/50 dark:bg-slate-950/50 text-slate-900 dark:text-white backdrop-blur-xl transition hover:border-brand-primary/30 hover:bg-brand-primary/10 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                            >
                                <span class="sr-only">Next slide</span>

                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m9 18 6-6-6-6"
                                    />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="pointer-events-none absolute bottom-7 left-1/2 z-20 hidden -translate-x-1/2 lg:block">
            <div class="flex flex-col items-center gap-2 text-slate-500 dark:text-slate-600">
                <span class="text-[9px] font-black uppercase tracking-[0.25em]">
                    Scroll
                </span>

                <span class="relative block h-8 w-px overflow-hidden bg-slate-100 dark:bg-white/10">
                    <span class="absolute inset-x-0 top-0 h-3 animate-bounce bg-brand-primary"></span>
                </span>
            </div>
        </div>
    </section>

    {{-- ================================================================ --}}
    {{-- ABOUT PREVIEW                                                     --}}
    {{-- ================================================================ --}}

    @if (!$aboutSection || $aboutSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-20 lg:py-24 xl:py-28">
            <div class="pointer-events-none absolute -right-32 top-0 h-96 w-96 rounded-full bg-brand-secondary/[0.07] blur-[130px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid gap-12 lg:grid-cols-[0.86fr_1.14fr] lg:items-center"
                    data-reveal="up"
                >
                    <div>
                        <div class="flex items-center gap-4">
                            <span class="h-px w-12 bg-brand-primary"></span>

                            <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                                {{ $aboutSection?->subtitle ?: 'About Us' }}
                            </p>
                        </div>

                        <h2 class="mt-6 max-w-xl text-4xl font-black leading-[1.05] tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl lg:text-5xl xl:text-6xl">
                            {{ $aboutSection?->title
                                ?: 'One laboratory. Multiple engineering capabilities.' }}
                        </h2>
                    </div>

                    <div class="relative">
                        <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.055] to-white dark:to-white/[0.015] p-7 backdrop-blur-xl sm:p-9">
                            <p class="text-base leading-8 text-slate-600 dark:text-slate-400 sm:text-lg">
                                {{ $aboutSection?->content
                                    ?: 'We help individuals, businesses, institutions, and industries move from concept to implementation through engineering, design, prototyping, manufacturing, consulting, software development, and technical training.' }}
                            </p>

                            @if ($aboutButtonText && $aboutButtonUrl)
                                <a
                                    href="{{ $aboutButtonUrl }}"
                                    class="group mt-7 inline-flex items-center gap-3 text-sm font-black text-brand-primary transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                                >
                                    {{ $aboutButtonText }}

                                    <span class="transition group-hover:translate-x-1">
                                        →
                                    </span>
                                </a>
                            @endif
                        </div>

                        <div class="mt-5 w-fit rounded-2xl border border-brand-primary/15 bg-brand-primary/10 px-5 py-4 backdrop-blur-xl xl:absolute xl:-bottom-5 xl:-left-5 xl:mt-0">
                            <p class="text-2xl font-black text-slate-900 dark:text-white">
                                360°
                            </p>

                            <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary-dark dark:text-brand-primary-light">
                                Product Development
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================ --}}
    {{-- SERVICES                                                          --}}
    {{-- ================================================================ --}}

    @if (!$servicesSection || $servicesSection->is_active)
        <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-28">
            <div class="pointer-events-none absolute -left-32 top-40 h-96 w-96 rounded-full bg-brand-primary-dark/[0.06] blur-[130px]"></div>

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="flex flex-col justify-between gap-7 sm:flex-row sm:items-end"
                    data-reveal="up"
                >
                    <div class="max-w-3xl">
                        <div class="flex items-center gap-4">
                            <span class="h-px w-12 bg-brand-primary"></span>

                            <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                                {{ $servicesSection?->subtitle ?: 'What We Do' }}
                            </p>
                        </div>

                        <h2 class="mt-6 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                            {{ $servicesSection?->title ?: 'Featured Services' }}
                        </h2>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                            {{ $servicesSection?->content
                                ?: 'Explore selected engineering, manufacturing, fabrication, software, and consulting services.' }}
                        </p>
                    </div>

                    @if ($servicesButtonText && $servicesButtonUrl)
                        <a
                            href="{{ $servicesButtonUrl }}"
                            class="group inline-flex items-center gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] px-5 py-3 text-sm font-black text-slate-900 dark:text-white transition hover:border-brand-primary/25 hover:bg-brand-primary/[0.07] hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                        >
                            {{ $servicesButtonText }}

                            <span class="transition group-hover:translate-x-1">
                                →
                            </span>
                        </a>
                    @endif
                </div>

                <div class="mt-12 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @forelse ($featuredServices as $service)
                        <a
                            href="{{ route('services.show', $service) }}"
                            class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition duration-300 hover:-translate-y-2 hover:border-brand-primary/25"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="relative h-60 overflow-hidden bg-slate-50 dark:bg-slate-900">
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

                                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-white/15 dark:via-slate-950/15 to-transparent"></div>
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
                                        <span class="text-6xl font-black text-slate-200 dark:text-white/10">
                                            {{ strtoupper(substr(
                                                $service->title ?: 'VT',
                                                0,
                                                2
                                            )) }}
                                        </span>
                                    </div>
                                @endif

                                <div class="absolute left-5 top-5">
                                    <span class="rounded-full border border-brand-primary/20 bg-white/60 dark:bg-slate-950/60 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl">
                                        {{ $service->category?->name
                                            ?: 'Professional Service' }}
                                    </span>
                                </div>
                            </div>

                            <div class="relative p-6">
                                <div class="absolute -right-10 -top-10 h-28 w-28 rounded-full bg-brand-primary/[0.06] blur-2xl"></div>

                                <div class="relative">
                                    <h3 class="text-xl font-black text-slate-900 dark:text-white">
                                        {{ $service->title }}
                                    </h3>

                                    <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                        {{ $service->short_description
                                            ?: 'Professional engineering and technology services tailored to project requirements.' }}
                                    </p>

                                    <div class="mt-6 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                        <span class="text-sm font-black text-brand-primary">
                                            View Service
                                        </span>

                                        <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] text-slate-900 dark:text-white transition group-hover:border-brand-primary/20 group-hover:bg-brand-primary/10 group-hover:text-brand-primary-dark dark:group-hover:text-brand-primary-light">
                                            →
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        @foreach ($fallbackServices as $fallbackService)
                            <article
                                class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 transition duration-300 hover:-translate-y-2 hover:border-brand-primary/25"
                                data-service-card
                                data-reveal="up"
                            >
                                <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                                <div class="relative">
                                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10">
                                        <span class="h-3 w-3 rounded-full bg-brand-primary shadow-[0_0_22px_rgba(34,211,238,0.8)]"></span>
                                    </div>

                                    <h3 class="mt-8 text-xl font-black text-slate-900 dark:text-white">
                                        {{ $fallbackService['title'] }}
                                    </h3>

                                    <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                        {{ $fallbackService['description'] }}
                                    </p>

                                    <div class="mt-8 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                        <span class="text-sm font-black text-brand-primary">
                                            Professional Capability
                                        </span>

                                        <span class="text-slate-500 dark:text-slate-600">→</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </section>
    @endif

    {{-- ================================================================ --}}
    {{-- CAPABILITY STRIP                                                  --}}
    {{-- ================================================================ --}}

    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @forelse ($serviceCategories->take(4) as $category)
                    <a
                        href="{{ route(
                            'services.index',
                            ['category' => $category->slug]
                        ) }}"
                        class="group rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.025] p-6 transition hover:border-brand-primary/20 hover:bg-brand-primary/[0.045]"
                        data-reveal="up"
                    >
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                Capability
                            </span>

                            <span class="text-slate-500 dark:text-slate-600 transition group-hover:translate-x-1 group-hover:text-brand-primary-dark dark:group-hover:text-brand-primary-light">
                                →
                            </span>
                        </div>

                        <h3 class="mt-8 text-lg font-black text-slate-900 dark:text-white">
                            {{ $category->name }}
                        </h3>

                        <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-500">
                            {{ $category->description
                                ?: $category->services_count . ' available services' }}
                        </p>
                    </a>
                @empty
                    @foreach ($fallbackCapabilities as $capability)
                        <div
                            class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.025] p-6"
                            data-reveal="up"
                        >
                            <span class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                Capability
                            </span>

                            <h3 class="mt-8 text-lg font-black text-slate-900 dark:text-white">
                                {{ $capability['title'] }}
                            </h3>

                            <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-500">
                                {{ $capability['description'] }}
                            </p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================================================================ --}}
    {{-- FINAL CTA                                                         --}}
    {{-- ================================================================ --}}

    @if (!$projectCtaSection || $projectCtaSection->is_active)
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
                            <div class="flex items-center gap-4">
                                <span class="h-px w-12 bg-brand-primary"></span>

                                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                                    {{ $projectCtaSection?->subtitle ?: 'Start a Project' }}
                                </p>
                            </div>

                            <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $projectCtaSection?->title
                                    ?: 'Have an idea that needs engineering or technical expertise?' }}
                            </h2>

                            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $projectCtaSection?->content
                                    ?: 'Share your concept with our team and let us help you turn it into a practical, production-ready solution.' }}
                            </p>
                        </div>

                        @if ($ctaButtonText && $ctaButtonUrl)
                            <a
                                href="{{ $ctaButtonUrl }}"
                                class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 shadow-[0_18px_50px_rgba(34,211,238,0.18)] transition hover:-translate-y-1 hover:bg-brand-primary-light"
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
