@extends('frontend.layouts.app')

@section('title', 'WhatsApp Checkout')

@section('content')
    <section class="min-h-[700px] bg-white dark:bg-slate-950 py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <a
                href="{{ route('cart.index') }}"
                class="text-sm font-black text-slate-600 dark:text-slate-500 transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
            >
                ← Back to Cart
            </a>

            <div class="mt-8">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    WhatsApp Checkout
                </p>

                <h1 class="mt-5 text-5xl font-black tracking-[-0.04em] text-slate-900 dark:text-white sm:text-6xl">
                    Complete your request
                </h1>

                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-600 dark:text-slate-500">
                    Provide your contact and delivery details. Your order summary will then open in WhatsApp.
                </p>
            </div>

            <div class="mt-12 grid gap-8 lg:grid-cols-[1fr_400px]">
                <form
                    method="POST"
                    action="{{ route('checkout.whatsapp') }}"
                    class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/70 p-7 sm:p-9"
                >
                    @csrf

                    @if ($errors->any())
                        <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <div class="grid gap-6 sm:grid-cols-2">
                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Full name *
                            </span>

                            <input
                                type="text"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>

                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Phone number *
                            </span>

                            <input
                                type="text"
                                name="customer_phone"
                                value="{{ old('customer_phone') }}"
                                required
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Email
                            </span>

                            <input
                                type="email"
                                name="customer_email"
                                value="{{ old('customer_email') }}"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Delivery location
                            </span>

                            <textarea
                                name="delivery_address"
                                rows="3"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >{{ old('delivery_address') }}</textarea>
                        </label>

                        <label class="sm:col-span-2">
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Additional notes
                            </span>

                            <textarea
                                name="notes"
                                rows="5"
                                placeholder="Mention custom requirements, preferred delivery date, measurements, intended use, or other information."
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >{{ old('notes') }}</textarea>
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="mt-8 w-full rounded-2xl bg-emerald-400 px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-emerald-300"
                    >
                        Continue to WhatsApp
                    </button>
                </form>

                <aside class="h-fit rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/80 p-7 lg:sticky lg:top-28">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Order Summary
                    </p>

                    <div class="mt-6 space-y-5">
                        @foreach ($cartItems as $item)
                            <div class="border-b border-slate-200 dark:border-white/10 pb-5 last:border-b-0">
                                <div class="flex justify-between gap-5">
                                    <div>
                                        <p class="font-black text-slate-900 dark:text-white">
                                            {{ $item['name'] }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-500">
                                            Quantity:
                                            {{ $item['quantity'] }}
                                        </p>
                                    </div>

                                    <div class="text-right">
                                        @if ($item['price_on_request'] ?? false)
                                            <p class="text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                                On request
                                            </p>
                                        @else
                                            <p class="font-black text-slate-900 dark:text-white">
                                                {{ $item['currency'] }}
                                                {{ number_format(
                                                    (float) $item['subtotal'],
                                                    2
                                                ) }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                @if (!empty($item['selected_options']))
                                    <div class="mt-3 space-y-1">
                                        @foreach ($item['selected_options'] as $option => $value)
                                            <p class="text-xs text-slate-600 dark:text-slate-500">
                                                {{ Str::headline($option) }}:
                                                {{ $value }}
                                            </p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    @if ($containsPriceOnRequestItems)
                        <div class="mt-6 rounded-2xl border border-brand-primary/20 bg-brand-primary/[0.07] p-4">
                            <p class="text-sm font-black text-brand-primary-dark dark:text-brand-primary-light">
                                Final quotation required
                            </p>

                            <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                The team will confirm pricing based on quantities and selected configurations.
                            </p>
                        </div>
                    @endif

                    @if ($cartSubtotal > 0)
                        <div class="mt-6 flex justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                            <span class="text-sm text-slate-600 dark:text-slate-500">
                                Priced subtotal
                            </span>

                            <span class="text-xl font-black text-slate-900 dark:text-white">
                                {{ $cartCurrency }}
                                {{ number_format($cartSubtotal, 2) }}
                            </span>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endsection
