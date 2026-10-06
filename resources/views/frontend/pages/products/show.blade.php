@extends('frontend.layouts.app')

@php
    $productName = $product->name
        ?? $product->title
        ?? 'Technical Product';

    $productDescription = $product->short_description
        ?: 'A professionally developed technical product designed for practical use and reliable performance.';

    $featuredImage = $product->featured_image ?? null;

    $featuredImageExists = $featuredImage
        && Storage::disk('public')->exists($featuredImage);

    $gallery = collect($product->gallery ?? [])
        ->filter(
            fn ($image) => $image
                && Storage::disk('public')->exists($image)
        );

    $features = collect($product->features ?? [])
        ->filter();

    $specifications = collect(
        $product->specifications ?? []
    );

    $productOptions = collect($product->options ?? [])
        ->filter();

    $availabilityStatus = $product->manage_stock
        && !$product->allow_backorders
        && (int) $product->stock_quantity < 1
            ? 'out of stock'
            : 'available';

    $price = $product->current_price;
    $priceOnRequest = $price === null;

    $currency = $product->currency ?: 'RWF';
    $sku = $product->sku;
    $minimumQuantity = max(
        1,
        (int) ($product->minimum_order_quantity ?: 1)
    );

    $canAddToCart = $product->isPurchasable();
@endphp

@section(
    'title',
    $product->meta_title ?: $productName
)

@section(
    'meta_description',
    $product->meta_description ?: $productDescription
)

@section('content')
    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-20 sm:py-24">
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
            <a
                href="{{ route('products') }}"
                class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-400 transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
            >
                ← Back to Products
            </a>

            @if (session('success'))
                <div class="mt-7 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mt-10 grid gap-12 lg:grid-cols-[1fr_0.95fr] lg:items-start">
                <div data-reveal="left">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        {{ $product->category?->name ?: 'Technical Product' }}
                    </p>

                    <h1 class="mt-5 text-5xl font-black leading-[1.02] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-7xl">
                        {{ $productName }}
                    </h1>

                    <p class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg">
                        {{ $productDescription }}
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <span class="rounded-full border border-brand-primary/20 bg-brand-primary/10 px-4 py-2 text-xs font-black uppercase tracking-[0.14em] text-brand-primary-dark dark:text-brand-primary-light">
                            {{ Str::headline($availabilityStatus) }}
                        </span>

                        @if ($sku)
                            <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-slate-600 dark:text-slate-400">
                                SKU: {{ $sku }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-9 rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-6 sm:p-7">
                        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
                            <div>
                                <p class="text-xs font-black uppercase tracking-[0.15em] text-slate-600 dark:text-slate-500">
                                    Product Price
                                </p>

                                @if ($priceOnRequest)
                                    <p class="mt-2 text-2xl font-black text-slate-900 dark:text-white">
                                        Price on request
                                    </p>

                                    <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-500">
                                        Add it to your cart and send the required quantity and configuration through WhatsApp.
                                    </p>
                                @else
                                    <p class="mt-2 text-3xl font-black text-slate-900 dark:text-white">
                                        {{ $currency }}
                                        {{ number_format((float) $price, 2) }}
                                    </p>
                                @endif
                            </div>

                            @if ($product->sale_price)
                                <div class="rounded-full border border-emerald-400/20 bg-emerald-400/10 px-4 py-2 text-xs font-black uppercase tracking-wider text-emerald-700 dark:text-emerald-300">
                                    Sale price
                                </div>
                            @endif
                        </div>

                        @if ($canAddToCart)
                            <form
                                action="{{ route('cart.add', $product) }}"
                                method="POST"
                                class="mt-7 border-t border-slate-200 dark:border-white/10 pt-7"
                            >
                                @csrf

                                @if ($productOptions->isNotEmpty())
                                    <div class="grid gap-5 sm:grid-cols-2">
                                        @foreach ($productOptions as $option)
                                            @php
                                                $optionName = is_array($option)
                                                    ? data_get($option, 'name')
                                                    : null;

                                                $optionValues = collect(
                                                    is_array($option)
                                                        ? data_get($option, 'values', [])
                                                        : []
                                                )->filter();
                                            @endphp

                                            @if ($optionName && $optionValues->isNotEmpty())
                                                <label>
                                                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                                        {{ $optionName }}
                                                    </span>

                                                    <select
                                                        name="options[{{ $optionName }}]"
                                                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                                                    >
                                                        @foreach ($optionValues as $optionValue)
                                                            <option value="{{ $optionValue }}">
                                                                {{ $optionValue }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif

                                <div class="mt-5 grid gap-4 sm:grid-cols-[170px_1fr]">
                                    <label>
                                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                            Quantity
                                        </span>

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ old('quantity', $minimumQuantity) }}"
                                            min="{{ $minimumQuantity }}"
                                            @if (
                                                $product->manage_stock
                                                && !$product->allow_backorders
                                            )
                                                max="{{ $product->stock_quantity }}"
                                            @endif
                                            required
                                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                                        >

                                        @if ($minimumQuantity > 1)
                                            <p class="mt-2 text-xs text-slate-600 dark:text-slate-500">
                                                Minimum quantity:
                                                {{ $minimumQuantity }}
                                            </p>
                                        @endif
                                    </label>

                                    <div class="flex items-end">
                                        <button
                                            type="submit"
                                            class="group inline-flex w-full items-center justify-center gap-3 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white transition hover:-translate-y-1"
                                        >
                                            Add to Cart

                                            <span class="transition group-hover:translate-x-1">
                                                →
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="mt-7 border-t border-slate-200 dark:border-white/10 pt-7">
                                <p class="text-sm font-semibold text-red-700 dark:text-red-300">
                                    This product is not currently available for cart ordering.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <div data-reveal="scale">
                    <div class="relative overflow-hidden rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 shadow-2xl">
                        @if ($featuredImageExists)
                            <img
                                src="{{ Storage::url($featuredImage) }}"
                                alt="{{ $productName }}"
                                class="h-[560px] w-full object-cover"
                            >

                            <div class="absolute inset-0 bg-gradient-to-t from-white/50 dark:from-slate-950/50 via-transparent to-transparent"></div>
                        @else
                            <div class="relative flex h-[560px] items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 via-slate-100 dark:via-slate-900 to-brand-secondary/10">
                                <div
                                    class="absolute inset-0 opacity-[0.06] text-slate-900 dark:text-white"
                                    style="
                                        background-image:
                                        linear-gradient(currentColor 1px, transparent 1px),
                                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                                        background-size: 38px 38px;
                                    "
                                ></div>

                                <span class="relative text-8xl font-black text-slate-200 dark:text-white/10">
                                    {{ strtoupper(substr($productName, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-[0.7fr_1.3fr] lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Product Overview
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white">
                    Designed around function and performance.
                </h2>
            </div>

            <div
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-7 sm:p-9"
                data-reveal="right"
            >
                <div class="whitespace-pre-line text-base leading-9 text-slate-600 dark:text-slate-400">
                    {{ $product->description
                        ?: 'This product is designed to provide practical functionality, reliable operation, and flexibility for different use cases.' }}
                </div>
            </div>
        </div>
    </section>

    @if ($features->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Product Features
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    Core capabilities
                </h2>

                <div class="mt-10 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($features as $feature)
                        <div class="flex gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-5">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light">
                                ✓
                            </span>

                            <p class="text-sm font-semibold leading-7 text-slate-700 dark:text-slate-300">
                                {{ is_array($feature)
                                    ? data_get($feature, 'text', 'Product feature')
                                    : $feature }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="relative overflow-hidden border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/35 py-24">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:px-8">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    Technical Information
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    Product specifications
                </h2>
            </div>

            <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70">
                @foreach ($specifications as $key => $value)
                    <div class="grid gap-2 border-b border-slate-200 dark:border-white/10 px-6 py-5 last:border-b-0 sm:grid-cols-[0.7fr_1.3fr] sm:gap-6">
                        <p class="text-sm font-bold text-slate-600 dark:text-slate-500">
                            {{ is_numeric($key)
                                ? data_get($value, 'label', 'Specification')
                                : Str::headline($key) }}
                        </p>

                        <p class="text-sm font-black text-slate-900 dark:text-white">
                            {{ is_array($value)
                                ? data_get($value, 'value', 'Available on request')
                                : $value }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($gallery->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-black text-slate-900 dark:text-white">
                    Product gallery
                </h2>

                <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($gallery as $image)
                        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10">
                            <img
                                src="{{ Storage::url($image) }}"
                                alt="{{ $productName }}"
                                class="h-80 w-full object-cover"
                            >
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($relatedProducts->isNotEmpty())
        <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="text-4xl font-black text-slate-900 dark:text-white">
                    Related products
                </h2>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedProducts as $relatedProduct)
                        <a
                            href="{{ route('products.show', $relatedProduct) }}"
                            class="group rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 transition hover:-translate-y-2 hover:border-brand-primary/25"
                        >
                            <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                                {{ $relatedProduct->category?->name ?: 'Product' }}
                            </p>

                            <h3 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">
                                {{ $relatedProduct->name }}
                            </h3>

                            <p class="mt-4 line-clamp-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                                {{ $relatedProduct->short_description }}
                            </p>

                            <div class="mt-7 border-t border-slate-200 dark:border-white/10 pt-5 text-sm font-black text-brand-primary">
                                View Product →
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
