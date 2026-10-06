@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('products-hero');
    $catalogueSection = $sections->get('products-catalogue');
    $ctaSection = $sections->get('products-cta');

    $activeCategory = $categories->firstWhere('slug', $categorySlug);

    $fallbackProducts = collect([
        [
            'name' => 'Custom Electronic Controller',
            'category' => 'Electronics',
            'description' => 'A customizable embedded control solution for automation and smart systems.',
        ],
        [
            'name' => 'IoT Monitoring Device',
            'category' => 'Smart Systems',
            'description' => 'Connected monitoring hardware for environments, equipment, and field operations.',
        ],
        [
            'name' => 'Technical Training Kit',
            'category' => 'Education',
            'description' => 'A practical learning platform for electronics, programming, and prototyping.',
        ],
        [
            'name' => 'Custom Product Enclosure',
            'category' => 'Manufacturing',
            'description' => 'Designed and fabricated enclosures for electronic and mechanical products.',
        ],
        [
            'name' => 'Laboratory Workstation',
            'category' => 'Laboratory Equipment',
            'description' => 'A durable technical workspace configured for education, testing, and fabrication.',
        ],
        [
            'name' => 'Smart Agriculture Module',
            'category' => 'Agritech',
            'description' => 'A modular system for sensor-based agricultural monitoring and automation.',
        ],
    ]);

    $heroPrimaryText = data_get(
        $heroSection?->data,
        'primary_button_text',
        'Explore Products'
    );

    $heroPrimaryUrl = data_get(
        $heroSection?->data,
        'primary_button_url',
        '#product-catalogue'
    );

    $heroSecondaryText = data_get(
        $heroSection?->data,
        'secondary_button_text',
        'Request a Custom Product'
    );

    $heroSecondaryUrl = data_get(
        $heroSection?->data,
        'secondary_button_url',
        route('contact')
    );

    $ctaButtonText = data_get(
        $ctaSection?->data,
        'button_text',
        'Discuss a Custom Product'
    );

    $ctaButtonUrl = data_get(
        $ctaSection?->data,
        'button_url',
        route('contact')
    );
@endphp

@section(
    'title',
    $page?->meta_title
        ?: ($activeCategory?->name ?: 'Products')
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Explore technical products, electronics, smart systems, training kits, laboratory equipment, and custom manufacturing solutions.'
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
                    alt="{{ $heroSection->title ?: 'Products' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
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
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>

                    {{ $heroSection?->subtitle ?: 'Products & Solutions' }}
                </div>

                <h1
                    class="mt-7 max-w-5xl text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.2rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Technical products designed for real-world use.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'Explore electronics, smart systems, training equipment, laboratory solutions, manufactured products, and customizable technical platforms.' }}
                </p>

                <div
                    class="mt-9 flex flex-col gap-3 sm:flex-row"
                    data-hero-reveal
                >
                    @if ($heroPrimaryText && $heroPrimaryUrl)
                        <a
                            href="{{ $heroPrimaryUrl }}"
                            class="group inline-flex items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white transition hover:-translate-y-1"
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

            <div class="relative hidden min-h-[480px] lg:block" data-hero-reveal>
                <div
                    class="absolute inset-4 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-slate-100 dark:from-white/[0.07] to-white dark:to-white/[0.015] shadow-2xl backdrop-blur-2xl"
                    data-motion-layer="14"
                ></div>

                <div
                    class="absolute inset-10 overflow-hidden rounded-[2rem] border border-brand-primary/10 bg-slate-50/90 dark:bg-slate-900/75 p-7"
                    data-motion-layer="22"
                >
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-primary/[0.08] via-transparent to-brand-secondary/[0.08]"></div>

                    <div class="relative flex h-full flex-col justify-between">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                                Product Development
                            </p>

                            <h2 class="mt-5 text-4xl font-black leading-tight text-slate-900 dark:text-white">
                                Designed. Tested. Manufactured.
                            </h2>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            @foreach ([
                                'Electronics',
                                'Smart Systems',
                                'Training Kits',
                                'Custom Products',
                            ] as $capability)
                                <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] p-5">
                                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>

                                    <p class="mt-6 text-sm font-black text-slate-900 dark:text-white">
                                        {{ $capability }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div
                    class="absolute -bottom-2 right-0 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/90 px-5 py-4 shadow-xl backdrop-blur-xl"
                    data-motion-layer="-28"
                >
                    <p class="text-2xl font-black text-slate-900 dark:text-white">
                        OEM
                    </p>

                    <p class="mt-1 text-[10px] font-bold uppercase tracking-[0.16em] text-brand-primary">
                        Custom Development
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
                    href="{{ route('products') }}"
                    class="{{ !$categorySlug
                        ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                        : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}
                        rounded-full border px-4 py-2 text-xs font-black uppercase tracking-[0.12em] transition"
                >
                    All Products
                </a>

                @foreach ($categories as $category)
                    <a
                        href="{{ route(
                            'products',
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

    {{-- Catalogue --}}
    <section
        id="product-catalogue"
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
                        {{ $catalogueSection?->subtitle ?: 'Product Catalogue' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                        {{ $activeCategory?->name
                            ?: ($catalogueSection?->title ?: 'Explore our products') }}
                    </h2>

                    <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                        {{ $activeCategory?->description
                            ?: ($catalogueSection?->content
                                ?: 'Browse products developed, manufactured, supplied, or customized by our technical team.') }}
                    </p>
                </div>

                @if ($products->total() > 0)
                    <p class="text-sm font-semibold text-slate-600 dark:text-slate-500">
                        {{ $products->total() }}
                        {{ Str::plural('product', $products->total()) }}
                    </p>
                @endif
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($products as $product)
                    @php
                        $productName = $product->name
                            ?? $product->title
                            ?? 'Technical Product';

                        $productImage = $product->featured_image ?? null;

                        $productImageExists = $productImage
                            && Storage::disk('public')->exists($productImage);

                        $status = $product->availability_status
                            ?? 'available';

                        $price = $product->price ?? null;
                        $currency = $product->currency ?? 'USD';
                    @endphp

                    <a
                        href="{{ route('products.show', $product) }}"
                        class="group relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 transition duration-300 hover:-translate-y-2 hover:border-brand-primary/25"
                        data-service-card
                        data-reveal="up"
                    >
                        <div class="relative h-72 overflow-hidden bg-slate-50 dark:bg-slate-900">
                            @if ($productImageExists)
                                <img
                                    src="{{ Storage::url($productImage) }}"
                                    alt="{{ $productName }}"
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
                                        {{ strtoupper(substr($productName, 0, 2)) }}
                                    </span>
                                </div>
                            @endif

                            <div class="absolute left-5 top-5">
                                <span class="rounded-full border border-brand-primary/20 bg-white/65 dark:bg-slate-950/65 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light backdrop-blur-xl">
                                    {{ $product->category?->name ?: 'Product' }}
                                </span>
                            </div>

                            <div class="absolute right-5 top-5">
                                <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white/65 dark:bg-slate-950/65 px-3 py-1.5 text-[10px] font-black uppercase tracking-[0.12em] text-slate-900 dark:text-white backdrop-blur-xl">
                                    {{ Str::headline($status) }}
                                </span>
                            </div>
                        </div>

                        <div class="relative p-7">
                            <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <h3 class="text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $productName }}
                                </h3>

                                <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $product->short_description
                                        ?: 'A professionally developed technical product designed for practical use and reliable performance.' }}
                                </p>

                                <div class="mt-7 flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                                    <div>
                                        @if ($price)
                                            <p class="text-sm font-black text-slate-900 dark:text-white">
                                                {{ $currency }}
                                                {{ number_format((float) $price, 2) }}
                                            </p>
                                        @else
                                            <p class="text-sm font-black text-brand-primary">
                                                Request Pricing
                                            </p>
                                        @endif
                                    </div>

                                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] text-slate-900 dark:text-white transition group-hover:border-brand-primary/20 group-hover:bg-brand-primary/10 group-hover:text-brand-primary-dark dark:group-hover:text-brand-primary-light">
                                        →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    @foreach ($fallbackProducts as $fallbackProduct)
                        <article
                            class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7"
                            data-service-card
                            data-reveal="up"
                        >
                            <div class="absolute -right-16 -top-16 h-44 w-44 rounded-full bg-brand-primary/[0.06] blur-3xl"></div>

                            <div class="relative">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-brand-primary/15 bg-brand-primary/10">
                                    <span class="text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                        {{ strtoupper(substr(
                                            $fallbackProduct['name'],
                                            0,
                                            2
                                        )) }}
                                    </span>
                                </div>

                                <p class="mt-8 text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                                    {{ $fallbackProduct['category'] }}
                                </p>

                                <h3 class="mt-3 text-2xl font-black text-slate-900 dark:text-white">
                                    {{ $fallbackProduct['name'] }}
                                </h3>

                                <p class="mt-4 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                    {{ $fallbackProduct['description'] }}
                                </p>

                                <div class="mt-8 border-t border-slate-200 dark:border-white/10 pt-5">
                                    <span class="text-sm font-black text-brand-primary">
                                        Customisable Product
                                    </span>
                                </div>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>

            @if ($products->hasPages())
                <div class="mt-12">
                    {{ $products->links() }}
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

                    <div class="relative flex flex-col justify-between gap-10 lg:flex-row lg:items-center">
                        <div class="max-w-3xl">
                            <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                                {{ $ctaSection?->subtitle ?: 'Custom Development' }}
                            </p>

                            <h2 class="mt-6 text-3xl font-black leading-tight tracking-[-0.035em] text-slate-900 dark:text-white sm:text-4xl lg:text-5xl">
                                {{ $ctaSection?->title
                                    ?: 'Need a product designed specifically for your organisation?' }}
                            </h2>

                            <p class="mt-5 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-400 sm:text-base">
                                {{ $ctaSection?->content
                                    ?: 'Share your product idea, technical requirement, target users, and expected quantity. Our team can help with design, prototyping, testing, and manufacturing.' }}
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
