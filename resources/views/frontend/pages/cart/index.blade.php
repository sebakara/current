@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <section class="min-h-[700px] bg-white dark:bg-slate-950 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col justify-between gap-6 sm:flex-row sm:items-end">
                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        Product Request
                    </p>

                    <h1 class="mt-5 text-5xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-6xl">
                        Your cart
                    </h1>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-500">
                        Review quantities and configurations before continuing to WhatsApp checkout.
                    </p>
                </div>

                <a
                    href="{{ route('products') }}"
                    class="text-sm font-black text-brand-primary"
                >
                    Continue Shopping →
                </a>
            </div>

            @if (session('success'))
                <div class="mt-8 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mt-8 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($cartItems->isEmpty())
                <div class="mt-12 rounded-[2.5rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/60 p-10 text-center sm:p-16">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-[1.7rem] bg-brand-primary/10 text-3xl text-brand-primary-dark dark:text-brand-primary-light">
                        ◫
                    </div>

                    <h2 class="mt-7 text-3xl font-black text-slate-900 dark:text-white">
                        Your cart is empty
                    </h2>

                    <p class="mx-auto mt-4 max-w-xl text-sm leading-7 text-slate-600 dark:text-slate-500">
                        Explore the product catalogue and add the products you would like to purchase or request pricing for.
                    </p>

                    <a
                        href="{{ route('products') }}"
                        class="mt-8 inline-flex rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950"
                    >
                        Explore Products
                    </a>
                </div>
            @else
                <div class="mt-12 grid gap-8 lg:grid-cols-[1fr_380px]">
                    <div class="space-y-5">
                        @foreach ($cartItems as $item)
                            <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-6">
                                <div class="flex flex-col gap-6 sm:flex-row">
                                    <div class="flex h-28 w-28 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950">
                                        @if (
                                            !empty($item['image'])
                                            && Storage::disk('public')->exists($item['image'])
                                        )
                                            <img
                                                src="{{ Storage::url($item['image']) }}"
                                                alt="{{ $item['name'] }}"
                                                class="h-full w-full object-cover"
                                            >
                                        @else
                                            <span class="text-3xl font-black text-slate-200 dark:text-white/10">
                                                {{ strtoupper(substr($item['name'], 0, 2)) }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <div class="flex flex-col justify-between gap-4 sm:flex-row">
                                            <div>
                                                <a
                                                    href="{{ route('products.show', $item['slug']) }}"
                                                    class="text-2xl font-black text-slate-900 dark:text-white transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                                                >
                                                    {{ $item['name'] }}
                                                </a>

                                                @if (!empty($item['sku']))
                                                    <p class="mt-2 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-600">
                                                        SKU: {{ $item['sku'] }}
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="sm:text-right">
                                                @if ($item['price_on_request'] ?? false)
                                                    <p class="font-black text-brand-primary-dark dark:text-brand-primary-light">
                                                        Price on request
                                                    </p>
                                                @else
                                                    <p class="text-xl font-black text-slate-900 dark:text-white">
                                                        {{ $item['currency'] }}
                                                        {{ number_format(
                                                            (float) $item['subtotal'],
                                                            2
                                                        ) }}
                                                    </p>

                                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-500">
                                                        {{ $item['currency'] }}
                                                        {{ number_format(
                                                            (float) $item['unit_price'],
                                                            2
                                                        ) }}
                                                        each
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        @if (!empty($item['selected_options']))
                                            <div class="mt-5 flex flex-wrap gap-2">
                                                @foreach ($item['selected_options'] as $option => $value)
                                                    <span class="rounded-full border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-3 py-1.5 text-xs font-bold text-slate-600 dark:text-slate-400">
                                                        {{ Str::headline($option) }}:
                                                        {{ $value }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="mt-6 flex flex-col justify-between gap-4 border-t border-slate-200 dark:border-white/10 pt-5 sm:flex-row sm:items-end">
                                            <form
                                                method="POST"
                                                action="{{ route('cart.update', $item['key']) }}"
                                                class="flex items-end gap-3"
                                            >
                                                @csrf
                                                @method('PATCH')

                                                <label>
                                                    <span class="mb-2 block text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                                        Quantity
                                                    </span>

                                                    <input
                                                        type="number"
                                                        name="quantity"
                                                        value="{{ $item['quantity'] }}"
                                                        min="{{ $item['minimum_quantity'] ?? 1 }}"
                                                        @if ($item['maximum_quantity'] !== null)
                                                            max="{{ $item['maximum_quantity'] }}"
                                                        @endif
                                                        class="w-28 rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
                                                    >
                                                </label>

                                                <button
                                                    type="submit"
                                                    class="rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] px-4 py-3 text-sm font-black text-slate-900 dark:text-white"
                                                >
                                                    Update
                                                </button>
                                            </form>

                                            <form
                                                method="POST"
                                                action="{{ route('cart.remove', $item['key']) }}"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="text-sm font-black text-red-400"
                                                >
                                                    Remove Product
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <aside class="h-fit rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/80 p-7 lg:sticky lg:top-28">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                            Cart Summary
                        </p>

                        <div class="mt-6 flex justify-between border-b border-slate-200 dark:border-white/10 pb-5">
                            <span class="text-sm text-slate-600 dark:text-slate-500">
                                Products
                            </span>

                            <span class="font-black text-slate-900 dark:text-white">
                                {{ number_format($cartItems->sum('quantity')) }}
                            </span>
                        </div>

                        @if ($containsPriceOnRequestItems)
                            <div class="mt-5 rounded-2xl border border-brand-primary/20 bg-brand-primary/[0.07] p-4">
                                <p class="text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                    Pricing confirmation required
                                </p>

                                <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                    At least one product requires pricing based on its quantity, configuration, or project requirements.
                                </p>
                            </div>
                        @endif

                        @if ($cartSubtotal > 0)
                            <div class="mt-6 flex justify-between">
                                <span class="text-sm text-slate-600 dark:text-slate-500">
                                    Priced-product subtotal
                                </span>

                                <span class="text-xl font-black text-slate-900 dark:text-white">
                                    {{ $cartCurrency }}
                                    {{ number_format($cartSubtotal, 2) }}
                                </span>
                            </div>
                        @endif

                        <a
                            href="{{ route('checkout.index') }}"
                            class="mt-7 flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
                        >
                            Continue to WhatsApp Checkout
                        </a>

                        <form
                            method="POST"
                            action="{{ route('cart.clear') }}"
                            class="mt-3"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
                            >
                                Clear Cart
                            </button>
                        </form>
                    </aside>
                </div>
            @endif
        </div>
    </section>
@endsection
