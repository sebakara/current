@extends('frontend.layouts.app')

@php
    $serviceTitle = $service->title ?: 'Professional Service';

    $serviceDescription = $service->short_description
        ?: 'Professional engineering and technology services tailored to your project requirements.';

    $featuredImageExists = $service->featured_image
        && Storage::disk('public')->exists($service->featured_image);

    $benefits = collect(
        preg_split(
            '/\r\n|\r|\n/',
            $service->benefits ?: ''
        )
    )
        ->map(fn ($item) => trim($item))
        ->filter();

    $processSteps = collect(
        preg_split(
            '/\r\n|\r|\n/',
            $service->process ?: ''
        )
    )
        ->map(fn ($item) => trim($item))
        ->filter();

    $gallery = collect($service->gallery ?? [])
        ->filter(
            fn ($image) => Storage::disk('public')->exists($image)
        );
@endphp

@section(
    'title',
    $service->meta_title ?: $serviceTitle
)

@section(
    'meta_description',
    $service->meta_description ?: $serviceDescription
)

@section('content')
    {{-- Hero --}}
    <section class="relative min-h-[680px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950">
        @if ($featuredImageExists)
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($service->featured_image) }}"
                    alt="{{ $serviceTitle }}"
                    class="h-full w-full object-cover"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/30 dark:to-slate-950/30"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/30 dark:to-slate-950/30"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-brand-primary-dark/10 blur-[130px]"></div>

                <div class="absolute right-0 bottom-0 h-[30rem] w-[30rem] rounded-full bg-brand-secondary/10 blur-[150px]"></div>

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

        <div class="relative mx-auto grid min-h-[680px] max-w-7xl items-center gap-12 px-4 py-24 sm:px-6 lg:grid-cols-[1fr_0.7fr] lg:px-8">
            <div data-reveal="up">
                <a
                    href="{{ route('services.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-400 transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                >
                    ← Back to Services
                </a>

                <p class="mt-10 text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    {{ $service->category?->name ?: 'Professional Service' }}
                </p>

                <h1 class="mt-5 max-w-4xl text-5xl font-black leading-[1.02] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                    {{ $serviceTitle }}
                </h1>

                <p class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg">
                    {{ $serviceDescription }}
                </p>

                <div class="mt-9 flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route('contact') }}"
                        class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white shadow-[0_18px_50px_rgba(34,211,238,0.18)] transition hover:-translate-y-1"
                    >
                        Request This Service
                        <span class="transition group-hover:translate-x-1">→</span>
                    </a>

                    <a
                        href="{{ route('services.index') }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                    >
                        Explore More Services
                    </a>
                </div>
            </div>

            <div class="hidden lg:block" data-reveal="scale">
                <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] p-7 backdrop-blur-2xl">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Service Overview
                    </p>

                    <dl class="mt-6 space-y-5">
                        <div class="flex items-center justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Category
                            </dt>

                            <dd class="text-sm font-black text-slate-900 dark:text-white">
                                {{ $service->category?->name ?: 'General' }}
                            </dd>
                        </div>

                        <div class="flex items-center justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Delivery
                            </dt>

                            <dd class="text-sm font-black text-slate-900 dark:text-white">
                                Project Based
                            </dd>
                        </div>

                        <div class="flex items-center justify-between gap-5 border-b border-slate-200 dark:border-white/10 pb-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Consultation
                            </dt>

                            <dd class="text-sm font-black text-slate-900 dark:text-white">
                                Available
                            </dd>
                        </div>

                        <div class="flex items-center justify-between gap-5">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">
                                Views
                            </dt>

                            <dd class="text-sm font-black text-slate-900 dark:text-white">
                                {{ number_format($service->views) }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    {{-- Description --}}
    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Service Details
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                    What this service includes
                </h2>
            </div>

            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-7 sm:p-9"
                data-reveal="right"
            >
                <div class="whitespace-pre-line text-base leading-9 text-slate-600 dark:text-slate-400">
                    {{ $service->description
                        ?: 'Our team provides a structured service designed around your objectives, technical requirements, timeline, and expected outcomes. Each engagement begins with understanding the project before recommending the most suitable implementation approach.' }}
                </div>
            </div>
        </div>
    </section>

    {{-- Benefits and process --}}
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-24">
        <div class="pointer-events-none absolute -left-40 top-1/2 h-96 w-96 rounded-full bg-brand-primary-dark/[0.05] blur-[140px]"></div>

        <div class="mx-auto grid max-w-7xl gap-6 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 sm:p-9"
                data-reveal="left"
            >
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Benefits
                </p>

                <h2 class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    Why choose this service
                </h2>

                <div class="mt-8 space-y-4">
                    @forelse ($benefits as $benefit)
                        <div class="flex items-start gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-4">
                            <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-primary/10 text-xs font-black text-brand-primary">
                                ✓
                            </span>

                            <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                {{ $benefit }}
                            </p>
                        </div>
                    @empty
                        @foreach ([
                            'Professional technical guidance',
                            'Solution adapted to project requirements',
                            'Structured implementation process',
                            'Quality-focused delivery',
                        ] as $benefit)
                            <div class="flex items-start gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-4">
                                <span class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-primary/10 text-xs font-black text-brand-primary">
                                    ✓
                                </span>

                                <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    {{ $benefit }}
                                </p>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>

            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 sm:p-9"
                data-reveal="right"
            >
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Process
                </p>

                <h2 class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    How we deliver
                </h2>

                <div class="mt-8 space-y-5">
                    @forelse ($processSteps as $step)
                        <div class="grid grid-cols-[44px_1fr] gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10 text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                            </div>

                            <div class="border-b border-slate-200 dark:border-white/10 pb-5">
                                <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                    {{ $step }}
                                </p>
                            </div>
                        </div>
                    @empty
                        @foreach ([
                            'Understand your project requirements',
                            'Define the technical approach',
                            'Design and implement the solution',
                            'Test, review, and deliver',
                        ] as $step)
                            <div class="grid grid-cols-[44px_1fr] gap-4">
                                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10 text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </div>

                                <div class="border-b border-slate-200 dark:border-white/10 pb-5">
                                    <p class="text-sm leading-7 text-slate-600 dark:text-slate-400">
                                        {{ $step }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- Gallery --}}
    @if ($gallery->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        Gallery
                    </p>

                    <h2 class="mt-4 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                        Service visuals
                    </h2>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($gallery as $image)
                        <div
                            class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10"
                            data-reveal="scale"
                        >
                            <img
                                src="{{ Storage::url($image) }}"
                                alt="{{ $serviceTitle }}"
                                class="h-72 w-full object-cover transition duration-700 group-hover:scale-110"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Related services --}}
    @if ($relatedServices->isNotEmpty())
        <section class="bg-slate-50/90 dark:bg-slate-900/30 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between gap-6" data-reveal="up">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            Related Services
                        </p>

                        <h2 class="mt-4 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                            Explore similar capabilities
                        </h2>
                    </div>

                    <a
                        href="{{ route('services.index') }}"
                        class="hidden text-sm font-black text-brand-primary transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light sm:inline-flex"
                    >
                        View All Services →
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedServices as $relatedService)
                        <a
                            href="{{ route('services.show', $relatedService) }}"
                            class="group rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 transition hover:-translate-y-2 hover:border-brand-primary/25"
                            data-service-card
                            data-reveal="up"
                        >
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                {{ $relatedService->category?->name ?: 'Service' }}
                            </p>

                            <h3 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                                {{ $relatedService->title }}
                            </h3>

                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $relatedService->short_description
                                    ?: 'Professional technical service tailored to your requirements.' }}
                            </p>

                            <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                <span class="text-sm font-black text-brand-primary">
                                    View Service
                                </span>

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12 lg:p-14"
                data-reveal="scale"
            >
                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-primary/10 blur-[90px]"></div>

                <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                            Start Your Project
                        </p>

                        <h2 class="mt-5 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                            Ready to discuss {{ $serviceTitle }}?
                        </h2>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                            Contact our team with your goals, requirements, and timeline so we can recommend the right next step.
                        </p>
                    </div>

                    <a
                        href="{{ route('contact') }}"
                        class="group inline-flex shrink-0 items-center justify-center gap-3 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                    >
                        Contact Our Team
                        <span class="transition group-hover:translate-x-1">→</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
