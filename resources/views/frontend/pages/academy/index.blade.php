@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('academy-hero');
    $coursesSection = $sections->get('academy-courses');
    $ctaSection = $sections->get('academy-cta');

    $activeCategory = $categories->firstWhere(
        'slug',
        $categorySlug
    );

    $fallbackCourses = collect([
        [
            'title' => 'Electronics & PCB Design',
            'category' => 'Electronics',
            'description' => 'Learn circuit design, PCB development, assembly, and practical testing.',
            'duration' => '8 Weeks',
            'mode' => 'Practical',
        ],
        [
            'title' => '3D Design & Printing',
            'category' => 'Digital Fabrication',
            'description' => 'Develop 3D models and turn them into functional physical prototypes.',
            'duration' => '6 Weeks',
            'mode' => 'Hands-on',
        ],
        [
            'title' => 'Embedded Systems & IoT',
            'category' => 'Smart Systems',
            'description' => 'Build connected electronic systems using sensors and microcontrollers.',
            'duration' => '10 Weeks',
            'mode' => 'Hybrid',
        ],
        [
            'title' => 'Software Development',
            'category' => 'Technology',
            'description' => 'Develop practical web and software applications through project-based learning.',
            'duration' => '12 Weeks',
            'mode' => 'Practical',
        ],
        [
            'title' => 'Product Development',
            'category' => 'Innovation',
            'description' => 'Move from problem identification through design, prototyping, and validation.',
            'duration' => '8 Weeks',
            'mode' => 'Project-based',
        ],
        [
            'title' => 'Industrial Automation',
            'category' => 'Engineering',
            'description' => 'Learn control systems, sensors, automation concepts, and implementation.',
            'duration' => '10 Weeks',
            'mode' => 'Hands-on',
        ],
    ]);

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Explore Courses'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        '#academy-courses'
    );

    $heroSecondaryText = data_get(
        $heroSection?->data,
        'secondary_button_text',
        'Contact the Academy'
    );

    $heroSecondaryUrl = data_get(
        $heroSection?->data,
        'secondary_button_url',
        route('contact')
    );

    $ctaButtonText = data_get(
        $ctaSection?->data,
        'button_text',
        'Explore Training Courses'
    );

    $ctaButtonUrl = data_get(
        $ctaSection?->data,
        'button_url',
        '#academy-courses'
    );
@endphp

@section(
    'title',
    $page?->meta_title
        ?: ($activeCategory?->name ?: 'Training Academy')
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Explore practical engineering, electronics, manufacturing, software, and innovation training courses.'
)

@section('content')
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
                    alt="{{ $heroSection->title ?: 'Training Academy' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0">
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

        <div class="relative mx-auto grid min-h-[720px] max-w-7xl items-center gap-14 px-4 py-24 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div>
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-brand-primary/20 bg-brand-primary/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl"
                    data-hero-reveal
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>

                    {{ $heroSection?->subtitle
                        ?: 'Learn by Building' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.2rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Practical skills for the technology-driven world.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'Build practical engineering, fabrication, electronics, software, product-development, and industrial skills through hands-on training.' }}
                </p>

                <div
                    class="mt-9 flex flex-col gap-3 sm:flex-row"
                    data-hero-reveal
                >
                    <a
                        href="{{ $heroPrimaryUrl }}"
                        class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white transition hover:-translate-y-1"
                    >
                        {{ $heroPrimaryText }}
                        <span class="transition group-hover:translate-x-1">→</span>
                    </a>

                    <a
                        href="{{ $heroSecondaryUrl }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                    >
                        {{ $heroSecondaryText }}
                    </a>
                </div>
            </div>

            <div class="relative hidden min-h-[500px] lg:block" data-hero-reveal>
                <div
                    class="absolute inset-4 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl backdrop-blur-2xl"
                    data-motion-layer="14"
                ></div>

                <div
                    class="absolute inset-10 rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/75 p-7"
                    data-motion-layer="22"
                >
                    <div class="flex h-full flex-col justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                Learning Model
                            </p>

                            <h2 class="mt-5 text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                Learn. Build. Test. Apply.
                            </h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ([
                                'Expert Guidance',
                                'Real Projects',
                                'Practical Tools',
                                'Career Skills',
                            ] as $feature)
                                <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>

                                    <p class="mt-6 text-sm font-black text-slate-900 dark:text-white">
                                        {{ $feature }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sticky top-20 z-30 border-b border-slate-200 dark:border-white/10 bg-white/90 dark:bg-slate-950/90 backdrop-blur-xl">
        <div class="mx-auto max-w-7xl overflow-x-auto px-4 sm:px-6 lg:px-8">
            <div class="flex min-w-max items-center gap-2 py-4">
                <a
                    href="{{ route('academy') }}"
                    class="
                        rounded-full border px-4 py-2 text-xs font-black uppercase
                        tracking-[0.12em] transition
                        {{ !$categorySlug
                            ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400'
                        }}
                    "
                >
                    All Courses
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route(
                            'academy',
                            ['category' => $category->slug]
                        ) }}"
                        class="
                            rounded-full border px-4 py-2 text-xs font-black uppercase
                            tracking-[0.12em] transition
                            {{ $categorySlug === $category->slug
                                ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                                : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400'
                            }}
                        "
                    >
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <section
        id="academy-courses"
        class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end"
                data-reveal="up"
            >
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        {{ $coursesSection?->subtitle
                            ?: 'Available Training' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $activeCategory?->name
                            ?: ($coursesSection?->title
                                ?: 'Explore our courses') }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $activeCategory?->description
                            ?: ($coursesSection?->content
                                ?: 'Choose practical training designed around real tools, projects, and technical skills.') }}
                    </p>
                </div>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($courses as $course)
                    @php
                        $imageExists =
                            $course->featured_image
                            && Storage::disk('public')->exists(
                                $course->featured_image
                            );
                    @endphp

                    <a
                        href="{{ route(
                            'academy.courses.show',
                            $course
                        ) }}"
                        class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition hover:-translate-y-2 hover:border-brand-primary/25"
                        data-reveal="up"
                    >
                        <div class="relative h-64 overflow-hidden">
                            @if ($imageExists)
                                <img
                                    src="{{ Storage::url(
                                        $course->featured_image
                                    ) }}"
                                    alt="{{ $course->title }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10">
                                    <span class="text-7xl font-black text-slate-200 dark:text-white/[0.06]">
                                        {{ strtoupper(substr(
                                            $course->title ?: 'VT',
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>
                            @endif

                            <div class="absolute left-5 top-5">
                                <span class="rounded-full border border-brand-primary/20 bg-white/65 dark:bg-slate-950/65 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl">
                                    {{ $course->category?->name
                                        ?: 'Training Course' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-7">
                            <h3 class="text-2xl font-black text-slate-900 dark:text-white">
                                {{ $course->title }}
                            </h3>

                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $course->short_description
                                    ?: 'Practical technical training designed around industry-relevant skills.' }}
                            </p>

                            <div class="mt-6 flex flex-wrap gap-2">
                                <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $course->duration ?: 'Flexible Duration' }}
                                </span>

                                <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $course->delivery_mode ?: 'Practical' }}
                                </span>
                            </div>

                            <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                <div>
                                    @if ($course->fee)
                                        <p class="font-black text-slate-900 dark:text-white">
                                            {{ $course->currency ?: 'RWF' }}
                                            {{ number_format(
                                                (float) $course->fee,
                                                0
                                            ) }}
                                        </p>
                                    @else
                                        <p class="font-black text-brand-primary">
                                            Contact for Fees
                                        </p>
                                    @endif
                                </div>

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    @foreach ($fallbackCourses as $fallbackCourse)
                        <article
                            class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                            data-reveal="up"
                        >
                            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                {{ $fallbackCourse['category'] }}
                            </p>

                            <h3 class="mt-5 text-2xl font-black text-slate-900 dark:text-white">
                                {{ $fallbackCourse['title'] }}
                            </h3>

                            <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $fallbackCourse['description'] }}
                            </p>

                            <div class="mt-7 flex gap-2 border-t border-slate-200 dark:border-white/10 pt-5">
                                <span class="rounded-full bg-white dark:bg-white/[0.04] px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $fallbackCourse['duration'] }}
                                </span>

                                <span class="rounded-full bg-white dark:bg-white/[0.04] px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400">
                                    {{ $fallbackCourse['mode'] }}
                                </span>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            @if ($courses->hasPages())
                <div class="mt-12">
                    {{ $courses->links() }}
                </div>
            @endif
        </div>
    </section>

    @if (!$ctaSection || $ctaSection->is_active)
        <section class="bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="rounded-[2.5rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10 p-8 sm:p-12 lg:p-14"
                    data-reveal="scale"
                >
                    <div class="flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                        <div class="max-w-3xl">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                                {{ $ctaSection?->subtitle
                                    ?: 'Build Your Skills' }}
                            </p>

                            <h2 class="mt-5 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $ctaSection?->title
                                    ?: 'Ready to learn through practical experience?' }}
                            </h2>

                            <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $ctaSection?->content
                                    ?: 'Explore our courses and apply for the programme that matches your technical goals.' }}
                            </p>
                        </div>

                        <a
                            href="{{ $ctaButtonUrl }}"
                            class="inline-flex shrink-0 rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950"
                        >
                            {{ $ctaButtonText }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
