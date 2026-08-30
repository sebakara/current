@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('vtl-woods-hero');
    $introSection = $sections->get('vtl-woods-introduction');
    $capabilitiesSection = $sections->get('vtl-woods-capabilities');
    $productsSection = $sections->get('vtl-woods-products');
    $processSection = $sections->get('vtl-woods-process');
    $gallerySection = $sections->get('vtl-woods-gallery');
    $whySection = $sections->get('vtl-woods-why-us');
    $ctaSection = $sections->get('vtl-woods-cta');

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Explore Our Craft'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        '#woods-products'
    );

    $heroSecondaryText = data_get(
        $heroSection?->data,
        'secondary_button_text',
        'Request Custom Furniture'
    );

    $heroSecondaryUrl = data_get(
        $heroSection?->data,
        'secondary_button_url',
        route('contact')
    );

    $capabilities = data_get(
        $capabilitiesSection?->data,
        'items',
        [
            [
                'title' => 'Custom Furniture',
                'description' => 'Furniture designed and produced around your measurements, space, style, and practical needs.',
            ],
            [
                'title' => 'Office Furniture',
                'description' => 'Professional desks, workstations, shelves, cabinets, meeting tables, and storage solutions.',
            ],
            [
                'title' => 'Home Interiors',
                'description' => 'Beds, wardrobes, dining tables, TV units, kitchen cabinets, and fitted interior furniture.',
            ],
            [
                'title' => 'Hotel Furniture',
                'description' => 'Durable hospitality furniture for bedrooms, reception areas, restaurants, and guest spaces.',
            ],
            [
                'title' => 'Wood Prototyping',
                'description' => 'Functional prototypes and small production runs for furniture and product-development projects.',
            ],
            [
                'title' => 'Repairs and Refinishing',
                'description' => 'Restoration, repair, refinishing, resizing, and improvement of existing wooden furniture.',
            ],
        ]
    );

    $processSteps = data_get(
        $processSection?->data,
        'steps',
        [
            [
                'title' => 'Consultation',
                'description' => 'We understand your space, measurements, use case, style, budget, and delivery expectations.',
            ],
            [
                'title' => 'Design',
                'description' => 'Our team prepares the concept, dimensions, materials, finishes, and production approach.',
            ],
            [
                'title' => 'Production',
                'description' => 'The approved design is manufactured with attention to strength, detail, finish, and quality.',
            ],
            [
                'title' => 'Delivery',
                'description' => 'The completed furniture is inspected, delivered, installed, and handed over to the client.',
            ],
        ]
    );

    $whyItems = data_get(
        $whySection?->data,
        'items',
        [
            'Furniture designed for the actual space and intended use',
            'Practical engineering and fabrication experience',
            'Careful material selection and quality control',
            'Support from concept and measurement to installation',
            'Solutions for homes, offices, hotels, schools, and businesses',
            'Custom production instead of one-size-fits-all furniture',
        ]
    );

    $fallbackProducts = collect([
        [
            'name' => 'Custom Office Desk',
            'category' => 'Office Furniture',
            'description' => 'A functional workspace designed around the user, equipment, and available space.',
        ],
        [
            'name' => 'Hotel Bedroom Set',
            'category' => 'Hospitality',
            'description' => 'Coordinated bed, bedside units, desk, wardrobe, and luggage-storage furniture.',
        ],
        [
            'name' => 'Modern Wardrobe',
            'category' => 'Home Furniture',
            'description' => 'Custom internal storage, doors, finishing, dimensions, and room integration.',
        ],
        [
            'name' => 'Dining Table Set',
            'category' => 'Interior Furniture',
            'description' => 'A strong and refined dining solution produced for residential or commercial use.',
        ],
        [
            'name' => 'Kitchen Cabinets',
            'category' => 'Fitted Furniture',
            'description' => 'Made-to-measure storage planned around appliances, movement, and kitchen workflow.',
        ],
        [
            'name' => 'Reception Counter',
            'category' => 'Commercial Furniture',
            'description' => 'A professional front-desk solution aligned with the organisation’s space and brand.',
        ],
    ]);

    $galleryImages = collect(
        data_get($gallerySection?->data, 'images', [])
    )->filter(
        fn ($image) =>
            is_string($image)
            && $image !== ''
            && Storage::disk('public')->exists($image)
    );

    $whatsAppNumber = preg_replace(
        '/\D+/',
        '',
        setting('whatsapp_number', '250791376812')
    );

    $whatsAppMessage = rawurlencode(
        'Hello VTLABS, I would like to discuss a custom furniture or woodwork project.'
    );
@endphp

@section(
    'title',
    $page?->meta_title ?: 'VTL Woods'
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Custom furniture, office furniture, hotel furniture, home interiors, wood fabrication, repairs, and fitted furniture by VTL Woods.'
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
                    alt="{{ $heroSection->title ?: 'VTL Woods' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-12"
                >

                <div class="absolute inset-0 bg-white/60 dark:bg-slate-950/60"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/20 dark:to-slate-950/20"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-white/30 dark:to-slate-950/30"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute -left-40 top-0 h-[34rem] w-[34rem] rounded-full bg-amber-500/10 blur-[150px]"
                    data-motion-layer="18"
                ></div>

                <div
                    class="absolute -right-40 bottom-0 h-[34rem] w-[34rem] rounded-full bg-brand-primary-dark/[0.07] blur-[150px]"
                    data-motion-layer="-24"
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
            </div>
        @endif

        <div class="relative mx-auto grid min-h-[760px] max-w-7xl items-center gap-14 px-4 py-24 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8">
            <div>
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-amber-400/20 bg-amber-400/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-amber-700 dark:text-amber-300 backdrop-blur-xl"
                    data-hero-reveal
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-amber-400"></span>

                    {{ $heroSection?->subtitle
                        ?: 'Design. Craft. Deliver.' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.2rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Furniture crafted around your space and purpose.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'VTL Woods designs and produces custom furniture, fitted interiors, hotel furniture, office solutions, home furniture, and practical wood products.' }}
                </p>

                <div
                    class="mt-9 flex flex-col gap-3 sm:flex-row"
                    data-hero-reveal
                >
                    <a
                        href="{{ $heroPrimaryUrl }}"
                        class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-amber-400 to-orange-500 px-6 py-4 text-sm font-black text-slate-950 shadow-[0_18px_50px_rgba(251,191,36,0.16)] transition hover:-translate-y-1"
                    >
                        {{ $heroPrimaryText }}

                        <span class="transition group-hover:translate-x-1">
                            →
                        </span>
                    </a>

                    <a
                        href="{{ $heroSecondaryUrl }}"
                        class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.045] px-6 py-4 text-sm font-bold text-slate-900 dark:text-white backdrop-blur-xl transition hover:-translate-y-1 hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                    >
                        {{ $heroSecondaryText }}
                    </a>
                </div>
            </div>

            <div
                class="relative hidden min-h-[520px] lg:block"
                data-hero-reveal
            >
                <div
                    class="absolute inset-4 rounded-[2.6rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl backdrop-blur-2xl"
                    data-motion-layer="12"
                ></div>

                <div
                    class="absolute inset-10 overflow-hidden rounded-[2rem] border border-amber-400/10 bg-slate-50/90 dark:bg-slate-900/75 p-7"
                    data-motion-layer="22"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-400/[0.08] via-transparent to-brand-primary/[0.05]"></div>

                    <div
                        class="absolute inset-0 opacity-[0.05] text-slate-900 dark:text-white"
                        style="
                            background-image:
                            linear-gradient(currentColor 1px, transparent 1px),
                            linear-gradient(90deg, currentColor 1px, transparent 1px);
                            background-size: 38px 38px;
                        "
                    ></div>

                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-amber-400">
                                Custom Production
                            </p>

                            <h2 class="mt-5 max-w-sm text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                From measurement to final installation.
                            </h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ([
                                'Furniture Design',
                                'Precision Cutting',
                                'Custom Finishing',
                                'On-site Installation',
                            ] as $feature)
                                <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-5">
                                    <span class="text-xs font-black text-amber-400">
                                        {{ str_pad(
                                            $loop->iteration,
                                            2,
                                            '0',
                                            STR_PAD_LEFT
                                        ) }}
                                    </span>

                                    <p class="mt-5 text-sm font-black text-slate-900 dark:text-white">
                                        {{ $feature }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="absolute -left-3 top-20 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="34"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        Custom
                    </p>

                    <p class="mt-1 text-[10px] font-black uppercase tracking-[0.15em] text-amber-400">
                        Made to Measure
                    </p>
                </div>

                <div
                    class="absolute -bottom-1 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="-28"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        360°
                    </p>

                    <p class="mt-1 text-[10px] font-black uppercase tracking-[0.15em] text-amber-400">
                        Design to Delivery
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Introduction --}}
    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.75fr_1.25fr] lg:items-center lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                    {{ $introSection?->subtitle
                        ?: 'About VTL Woods' }}
                </p>

                <h2 class="mt-5 text-4xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $introSection?->title
                        ?: 'Woodworking supported by design and engineering.' }}
                </h2>
            </div>

            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-7 sm:p-9"
                data-reveal="right"
            >
                <p class="whitespace-pre-line text-base leading-9 text-slate-600 dark:text-slate-400">
                    {{ $introSection?->content
                        ?: 'VTL Woods combines furniture design, practical engineering, fabrication, finishing, and installation to deliver dependable wood products. Every project begins with the actual needs of the client, the available space, and the intended use.' }}
                </p>
            </div>
        </div>
    </section>

    {{-- Capabilities --}}
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="pointer-events-none absolute -left-40 top-1/3 h-96 w-96 rounded-full bg-amber-500/[0.05] blur-[140px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div data-reveal="up">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                    {{ $capabilitiesSection?->subtitle
                        ?: 'What We Make' }}
                </p>

                <h2 class="mt-5 max-w-3xl text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $capabilitiesSection?->title
                        ?: 'Furniture and wood solutions for different environments.' }}
                </h2>

                <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                    {{ $capabilitiesSection?->content
                        ?: 'We work with residential, commercial, hospitality, education, and institutional clients.' }}
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($capabilities as $capability)
                    <article
                        class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 transition hover:-translate-y-2 hover:border-amber-400/25"
                        data-reveal="up"
                    >
                        <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-amber-400/[0.05] blur-3xl"></div>

                        <div class="relative">
                            <span class="text-5xl font-black text-slate-200 dark:text-white/[0.04]">
                                {{ str_pad(
                                    $loop->iteration,
                                    2,
                                    '0',
                                    STR_PAD_LEFT
                                ) }}
                            </span>

                            <h3 class="mt-10 text-2xl font-black text-slate-900 dark:text-white">
                                {{ is_array($capability)
                                    ? data_get(
                                        $capability,
                                        'title',
                                        'Woodwork Service'
                                    )
                                    : $capability }}
                            </h3>

                            <p class="mt-5 text-sm leading-8 text-slate-600 dark:text-slate-500">
                                {{ is_array($capability)
                                    ? data_get(
                                        $capability,
                                        'description',
                                        'Custom furniture and woodworking services.'
                                    )
                                    : 'Custom furniture and woodworking services.' }}
                            </p>

                            <div class="mt-8 border-t border-slate-200 dark:border-white/10 pt-5">
                                <span class="text-sm font-black text-amber-400">
                                    Custom-made solution
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Products --}}
    <section
        id="woods-products"
        class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24"
    >
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end"
                data-reveal="up"
            >
                <div class="max-w-3xl">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                        {{ $productsSection?->subtitle
                            ?: 'Furniture Collection' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $productsSection?->title
                            ?: 'Explore furniture and wood products.' }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $productsSection?->content
                            ?: 'Products can be adjusted to match your dimensions, materials, finishing, branding, quantity, and installation requirements.' }}
                    </p>
                </div>

                @if (Route::has('products'))
                    <a
                        href="{{ route('products') }}"
                        class="text-sm font-black text-amber-400 transition hover:text-amber-700 dark:hover:text-amber-300"
                    >
                        View All Products →
                    </a>
                @endif
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($woodProducts as $product)
                    @php
                        $productImage =
                            $product->featured_image
                            ?: $product->image;

                        $productImageExists =
                            $productImage
                            && Storage::disk('public')->exists(
                                $productImage
                            );
                    @endphp

                    <a
                        href="{{ route('products.show', $product) }}"
                        class="group overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition hover:-translate-y-2 hover:border-amber-400/25"
                        data-reveal="up"
                    >
                        <div class="relative h-72 overflow-hidden">
                            @if ($productImageExists)
                                <img
                                    src="{{ Storage::url($productImage) }}"
                                    alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-110"
                                >

                                <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>
                            @else
                                <div class="flex h-full items-center justify-center bg-gradient-to-br from-amber-500/10 via-slate-100 dark:via-slate-900 to-brand-primary-dark/[0.06]">
                                    <span class="text-7xl font-black text-slate-200 dark:text-white/[0.06]">
                                        {{ strtoupper(substr(
                                            $product->name ?: 'VT',
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>
                            @endif

                            @if ($product->is_featured)
                                <span class="absolute left-5 top-5 rounded-full border border-amber-400/20 bg-white/65 dark:bg-slate-950/65 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-amber-700 dark:text-amber-300 backdrop-blur-xl">
                                    Featured
                                </span>
                            @endif
                        </div>

                        <div class="p-7">
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-amber-400">
                                {{ $product->category?->name
                                    ?: 'VTL Woods' }}
                            </p>

                            <h3 class="mt-3 text-2xl font-black text-slate-900 dark:text-white">
                                {{ $product->name }}
                            </h3>

                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $product->short_description
                                    ?: $product->description
                                    ?: 'Custom furniture and woodwork produced around practical requirements.' }}
                            </p>

                            <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                <span class="text-sm font-black text-amber-400">
                                    View Product
                                </span>

                                <span class="transition group-hover:translate-x-1">
                                    →
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    @foreach ($fallbackProducts as $fallbackProduct)
                        <article
                            class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                            data-reveal="up"
                        >
                            <div class="absolute -right-20 -top-20 h-52 w-52 rounded-full bg-amber-400/[0.05] blur-3xl"></div>

                            <div class="relative">
                                <p class="text-xs font-black uppercase tracking-[0.16em] text-amber-400">
                                    {{ $fallbackProduct['category'] }}
                                </p>

                                <h3 class="mt-5 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $fallbackProduct['name'] }}
                                </h3>

                                <p class="mt-5 text-sm leading-8 text-slate-600 dark:text-slate-500">
                                    {{ $fallbackProduct['description'] }}
                                </p>

                                <div class="mt-10 border-t border-slate-200 dark:border-white/10 pt-5">
                                    <a
                                        href="{{ route('contact') }}"
                                        class="text-sm font-black text-amber-400"
                                    >
                                        Request This Product →
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    {{-- Process --}}
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-reveal="up">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                    {{ $processSection?->subtitle
                        ?: 'How It Works' }}
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $processSection?->title
                        ?: 'A clear path from idea to installed furniture.' }}
                </h2>

                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                    {{ $processSection?->content
                        ?: 'Each project follows a structured process so the design, measurements, materials, production, and delivery stay aligned.' }}
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ($processSteps as $step)
                    <article
                        class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                        data-reveal="up"
                    >
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-400/10 text-sm font-black text-amber-400">
                            {{ str_pad(
                                $loop->iteration,
                                2,
                                '0',
                                STR_PAD_LEFT
                            ) }}
                        </span>

                        <h3 class="mt-8 text-2xl font-black text-slate-900 dark:text-white">
                            {{ is_array($step)
                                ? data_get(
                                    $step,
                                    'title',
                                    'Project Stage'
                                )
                                : $step }}
                        </h3>

                        <p class="mt-5 text-sm leading-8 text-slate-600 dark:text-slate-500">
                            {{ is_array($step)
                                ? data_get(
                                    $step,
                                    'description',
                                    'A structured part of the production process.'
                                )
                                : 'A structured part of the production process.' }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Gallery --}}
    @if ($galleryImages->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal="up">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                        {{ $gallerySection?->subtitle
                            ?: 'Our Work' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $gallerySection?->title
                            ?: 'Furniture and woodwork gallery.' }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $gallerySection?->content
                            ?: 'A closer look at selected furniture, fabrication, finishing, and installation work.' }}
                    </p>
                </div>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($galleryImages as $image)
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
                                alt="VTL Woods project"
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

    {{-- Why choose us --}}
    <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:items-start lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                    {{ $whySection?->subtitle
                        ?: 'Why VTL Woods' }}
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $whySection?->title
                        ?: 'Furniture developed around real requirements.' }}
                </h2>

                <p class="mt-5 max-w-xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                    {{ $whySection?->content
                        ?: 'We focus on function, durability, dimensions, appearance, and the environment where the furniture will be used.' }}
                </p>
            </div>

            <div class="grid gap-4 sm:grid-cols-2" data-reveal="right">
                @foreach ($whyItems as $item)
                    <div class="flex gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-amber-400/10 text-sm font-black text-amber-400">
                            ✓
                        </span>

                        <p class="text-sm font-semibold leading-7 text-slate-700 dark:text-slate-300">
                            {{ is_array($item)
                                ? data_get(
                                    $item,
                                    'text',
                                    'Custom furniture service'
                                )
                                : $item }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative overflow-hidden bg-white dark:bg-slate-950 py-24">
        <div class="pointer-events-none absolute -bottom-32 left-1/3 h-96 w-96 rounded-full bg-amber-500/[0.07] blur-[150px]"></div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div
                class="relative overflow-hidden rounded-[2.5rem] border border-amber-400/15 bg-gradient-to-br from-amber-400/10 via-slate-100 dark:via-slate-900 to-brand-primary-dark/[0.06] p-8 sm:p-12 lg:p-16"
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

                <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-amber-400/10 blur-[90px]"></div>

                <div class="relative flex flex-col justify-between gap-10 lg:flex-row lg:items-center">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black uppercase tracking-[0.22em] text-amber-400">
                            {{ $ctaSection?->subtitle
                                ?: 'Custom Furniture Enquiry' }}
                        </p>

                        <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                            {{ $ctaSection?->title
                                ?: 'Have furniture you want designed and produced?' }}
                        </h2>

                        <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                            {{ $ctaSection?->content
                                ?: 'Share the furniture type, measurements, preferred design, quantity, location, timeline, and estimated budget with our team.' }}
                        </p>
                    </div>

                    <div class="flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col xl:flex-row">
                        <a
                            href="{{ route('contact') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-amber-400 px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-amber-300"
                        >
                            Request a Quotation
                        </a>

                        @if ($whatsAppNumber)
                            <a
                                href="https://wa.me/{{ $whatsAppNumber }}?text={{ $whatsAppMessage }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-7 py-4 text-sm font-black text-slate-900 dark:text-white transition hover:-translate-y-1 hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                            >
                                Chat on WhatsApp
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
