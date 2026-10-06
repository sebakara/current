@extends('frontend.layouts.app')

@php
    $pageTitle = 'Engineering & Technology Services';

    $pageDescription = 'Explore manufacturing, electronics, digital fabrication, software development, laboratory setup, consulting, and industrial solutions.';

    $activeCategory = $categories->firstWhere('slug', $categorySlug);

    $fallbackServices = collect([
        [
            'title' => 'Advanced Manufacturing',
            'description' => 'Prototype development, technical fabrication, and production support.',
            'category' => 'Manufacturing',
        ],
        [
            'title' => 'PCB Design',
            'description' => 'Electronic circuit design, prototyping, testing, and production preparation.',
            'category' => 'Electronics',
        ],
        [
            'title' => '3D Printing',
            'description' => 'Rapid prototyping and custom additive manufacturing solutions.',
            'category' => 'Digital Fabrication',
        ],
        [
            'title' => 'Laser Cutting',
            'description' => 'Precision cutting and fabrication for technical and creative applications.',
            'category' => 'Digital Fabrication',
        ],
        [
            'title' => 'Smart Laboratory Setup',
            'description' => 'Planning, equipment selection, installation, and technical laboratory implementation.',
            'category' => 'Laboratory Solutions',
        ],
        [
            'title' => 'Industrial Consulting',
            'description' => 'Practical engineering guidance for production and operational challenges.',
            'category' => 'Consulting',
        ],
    ]);
@endphp

@section('title', $activeCategory?->name ?: $pageTitle)
@section('meta_description', $pageDescription)

@section('content')
    {{-- Page hero --}}
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24 sm:py-28">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-brand-primary-dark/10 blur-[130px]"></div>

            <div class="absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-brand-secondary/10 blur-[140px]"></div>

            <div
                class="absolute inset-0 opacity-[0.035] text-slate-900 dark:text-white"
                style="
                    background-image:
                    linear-gradient(currentColor 1px, transparent 1px),
                    linear-gradient(90deg, currentColor 1px, transparent 1px);
                    background-size: 52px 52px;
                "
            ></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl" data-reveal="up">
                <div class="flex items-center gap-4">
                    <span class="h-px w-12 bg-brand-primary"></span>

                    <p class="text-xs font-black uppercase tracking-[0.24em] text-brand-primary">
                        {{ $activeCategory?->name ?: 'Our Capabilities' }}
                    </p>
                </div>

                <h1 class="mt-6 text-5xl font-black leading-[1.02] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                    {{ $activeCategory?->name ?: $pageTitle }}
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-400 sm:text-lg">
                    {{ $activeCategory?->description ?: $pageDescription }}
                </p>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section class="sticky top-20 z-30 border-b border-slate-200 dark:border-white/10 bg-white/90 dark:bg-slate-950/90 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 sm:px-6 lg:px-8">
            <div class="flex min-w-max items-center gap-2 py-4">
                <a
                    href="{{ route('services.index') }}"
                    class="{{ !$categorySlug
                        ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                        : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}
                        rounded-full border px-4 py-2 text-xs font-black uppercase tracking-[0.12em] transition"
                >
                    All Services
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route(
                            'services.index',
                            ['category' => $category->slug]
                        ) }}"
                        class="{{ $categorySlug === $category->slug
                            ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}
                            rounded-full border px-4 py-2 text-xs font-black uppercase tracking-[0.12em] transition"
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Services grid --}}
    <section class="relative overflow-hidden bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="pointer-events-none absolute -left-40 top-1/3 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        Services Catalogue
                    </p>

                    <h2 class="mt-4 text-3xl font-black tracking-[-0.03em] text-slate-900 dark:text-white sm:text-4xl">
                        {{ $activeCategory
                            ? $activeCategory->name . ' Services'
                            : 'Explore Our Services' }}
                    </h2>
                </div>

                @if ($services->total() > 0)
                    <p class="text-sm text-slate-600 dark:text-slate-500">
                        {{ $services->total() }}
                        {{ Str::plural('service', $services->total()) }}
                    </p>
                @endif
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($services as $service)
                    <a
                        href="{{ route('services.show', $service) }}"
                        class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition duration-300 hover:-translate-y-2 hover:border-brand-primary/25"
                        data-service-card
                        data-reveal="up"
                    >
                        <div class="relative h-64 overflow-hidden bg-slate-50 dark:bg-slate-900">
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

                                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-white/10 dark:via-slate-950/10 to-transparent"></div>
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
                                            $service->title ?: 'VT',
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>
                            @endif

                            <div class="absolute left-5 top-5">
                                <span class="rounded-full border border-brand-primary/20 bg-white/65 dark:bg-slate-950/65 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl">
                                    {{ $service->category?->name
                                        ?: 'Professional Service' }}
                                </span>
                            </div>

                            @if ($service->is_featured)
                                <div class="absolute right-5 top-5">
                                    <span class="rounded-full border border-slate-200 dark:border-white/10 bg-slate-100 dark:bg-white/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-slate-900 dark:text-white backdrop-blur-xl">
                                        Featured
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="relative p-7">
                            <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $service->title ?: 'Professional Service' }}
                                </h3>

                                <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $service->short_description
                                        ?: 'Professional engineering and technology services tailored to your project requirements.' }}
                                </p>

                                <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        Explore Service
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
                            class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10">
                                    <span class="h-3 w-3 rounded-full bg-brand-primary shadow-[0_0_22px_rgba(34,211,238,0.8)]"></span>
                                </div>

                                <p class="mt-8 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                    {{ $fallbackService['category'] }}
                                </p>

                                <h3 class="mt-3 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $fallbackService['title'] }}
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $fallbackService['description'] }}
                                </p>

                                <div class="mt-8 border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        Professional Capability
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            @if ($services->hasPages())
                <div class="mt-12">
                    {{ $services->links() }}
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-white dark:bg-slate-950 py-24">
        <div class="pointer-events-none absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-brand-secondary/[0.08] blur-[140px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12 lg:p-14"
                data-reveal="scale"
            >
                <div
                    class="absolute inset-0 opacity-[0.04] text-slate-900 dark:text-white"
                    style="
                        background-image:
                        linear-gradient(currentColor 1px, transparent 1px),
                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                        background-size: 42px 42px;
                    "
                ></div>

                <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            Custom Solutions
                        </p>

                        <h2 class="mt-5 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                            Need a service adapted to your exact project?
                        </h2>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                            Share your requirements and let our technical team recommend the right engineering, manufacturing, or development solution.
                        </p>
                    </div>

                    <a
                        href="{{ route('contact') }}"
                        class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                    >
                        Request a Quote

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
