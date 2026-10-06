@extends('admin.layouts.app')

@section('title', 'Order ' . $order->order_number)

@section('content')
    @php
        $statusStyles = [
            'pending' => 'border-amber-400/20 bg-amber-400/10 text-amber-700 dark:text-amber-300',
            'confirmed' => 'border-brand-secondary-light/20 bg-brand-secondary-light/10 text-brand-secondary dark:text-brand-secondary-light',
            'processing' => 'border-violet-400/20 bg-violet-400/10 text-violet-700 dark:text-violet-300',
            'ready' => 'border-brand-primary/20 bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light',
            'completed' => 'border-emerald-400/20 bg-emerald-400/10 text-emerald-700 dark:text-emerald-300',
            'cancelled' => 'border-red-400/20 bg-red-400/10 text-red-700 dark:text-red-300',
        ];

        $customerWhatsAppNumber = preg_replace(
            '/\D+/',
            '',
            $order->customer_phone
        );

        $customerWhatsAppMessage = rawurlencode(
            'Hello ' . $order->customer_name .
            ', we are contacting you regarding your VTLABS order ' .
            $order->order_number . '.'
        );
    @endphp

    <div class="space-y-8">
        {{-- Heading --}}
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <a
                    href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-slate-600 dark:text-slate-500 transition hover:text-brand-primary dark:hover:text-brand-primary-light"
                >
                    ← Back to Orders
                </a>

                <div class="mt-4 flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                        {{ $order->order_number }}
                    </h1>

                    <span
                        class="
                            inline-flex rounded-full border px-3 py-1.5
                            text-xs font-black uppercase tracking-wider
                            {{ $statusStyles[$order->status]
                                ?? 'border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] text-slate-700 dark:text-slate-300'
                            }}
                        "
                    >
                        {{ Str::headline($order->status) }}
                    </span>
                </div>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                    Created {{ $order->created_at->format(
                        'd F Y, H:i'
                    ) }}
                    through
                    {{ Str::headline($order->order_method) }}
                </p>
            </div>

            <a
                href="https://wa.me/{{ $customerWhatsAppNumber }}?text={{ $customerWhatsAppMessage }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-3 rounded-2xl bg-emerald-500 px-6 py-3.5 text-sm font-black text-white transition hover:-translate-y-0.5 hover:bg-emerald-400"
            >
                Contact Customer on WhatsApp
                <span>↗</span>
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-bold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="grid gap-8 xl:grid-cols-[1fr_380px]">
            {{-- Main content --}}
            <div class="space-y-8">
                {{-- Order items --}}
                <section class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
                    <div class="border-b border-slate-200 dark:border-white/10 px-6 py-5">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                            Ordered Products
                        </p>

                        <h2 class="mt-2 text-xl font-black text-slate-900 dark:text-white">
                            {{ $order->items->count() }}
                            {{ Str::plural(
                                'item',
                                $order->items->count()
                            ) }}
                        </h2>
                    </div>

                    <div class="divide-y divide-slate-200 dark:divide-white/10">
                        @foreach ($order->items as $item)
                            <article class="grid gap-5 p-6 sm:grid-cols-[100px_1fr_auto] sm:items-center">
                                <div class="overflow-hidden rounded-2xl bg-slate-50 dark:bg-slate-950">
                                    @if (
                                        $item->product?->featured_image
                                        && Storage::disk('public')->exists(
                                            $item->product->featured_image
                                        )
                                    )
                                        <img
                                            src="{{ Storage::url(
                                                $item->product->featured_image
                                            ) }}"
                                            alt="{{ $item->product_name }}"
                                            class="h-24 w-full object-cover"
                                        >
                                    @else
                                        <div class="flex h-24 items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 to-brand-secondary/10">
                                            <span class="text-2xl font-black text-slate-700 dark:text-white/10">
                                                {{ strtoupper(substr(
                                                    $item->product_name,
                                                    0,
                                                    2
                                                )) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <h3 class="text-lg font-black text-slate-900 dark:text-white">
                                        {{ $item->product_name }}
                                    </h3>

                                    @if ($item->sku)
                                        <p class="mt-1 text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                            SKU: {{ $item->sku }}
                                        </p>
                                    @endif

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                                        Quantity:
                                        <span class="font-black text-slate-700 dark:text-slate-300">
                                            {{ $item->quantity }}
                                        </span>
                                    </p>

                                    @foreach (
                                        $item->selected_options ?? []
                                        as $option => $value
                                    )
                                        <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                                            {{ Str::headline($option) }}:
                                            <span class="font-black text-slate-700 dark:text-slate-300">
                                                {{ $value }}
                                            </span>
                                        </p>
                                    @endforeach

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                                        Unit price:
                                        <span class="font-black text-slate-700 dark:text-slate-300">
                                            {{ $order->currency }}
                                            {{ number_format(
                                                (float) $item->unit_price,
                                                2
                                            ) }}
                                        </span>
                                    </p>
                                </div>

                                <p class="text-lg font-black text-slate-900 dark:text-white">
                                    {{ $order->currency }}
                                    {{ number_format(
                                        (float) $item->subtotal,
                                        2
                                    ) }}
                                </p>
                            </article>
                        @endforeach
                    </div>
                </section>

                {{-- Customer details --}}
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Customer Information
                    </p>

                    <div class="mt-6 grid gap-5 sm:grid-cols-2">
                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] p-5">
                            <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Customer
                            </p>

                            <p class="mt-2 font-black text-slate-900 dark:text-white">
                                {{ $order->customer_name }}
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] p-5">
                            <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Phone
                            </p>

                            <a
                                href="tel:{{ preg_replace(
                                    '/\s+/',
                                    '',
                                    $order->customer_phone
                                ) }}"
                                class="mt-2 block font-black text-slate-900 dark:text-white transition hover:text-brand-primary dark:hover:text-brand-primary-light"
                            >
                                {{ $order->customer_phone }}
                            </a>
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] p-5">
                            <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Email
                            </p>

                            @if ($order->customer_email)
                                <a
                                    href="mailto:{{ $order->customer_email }}"
                                    class="mt-2 block break-all font-black text-slate-900 dark:text-white transition hover:text-brand-primary dark:hover:text-brand-primary-light"
                                >
                                    {{ $order->customer_email }}
                                </a>
                            @else
                                <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                                    Not provided
                                </p>
                            @endif
                        </div>

                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] p-5">
                            <p class="text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                Delivery Location
                            </p>

                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-700 dark:text-slate-300">
                                {{ $order->delivery_address
                                    ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>
                </section>

                @if ($order->notes)
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                            Customer Notes
                        </p>

                        <p class="mt-5 whitespace-pre-line text-sm leading-7 text-slate-600 dark:text-slate-400">
                            {{ $order->notes }}
                        </p>
                    </section>
                @endif

                @if ($order->whatsapp_message)
                    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                            Original WhatsApp Order Message
                        </p>

                        <pre class="mt-5 whitespace-pre-wrap break-words rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-5 text-sm leading-7 text-slate-600 dark:text-slate-400">{{ $order->whatsapp_message }}</pre>
                    </section>
                @endif
            </div>

            {{-- Sidebar --}}
            <aside class="space-y-6">
                {{-- Status update --}}
                <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-6 xl:sticky xl:top-8">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                        Order Status
                    </p>

                    <form
                        action="{{ route(
                            'admin.orders.update-status',
                            $order
                        ) }}"
                        method="POST"
                        class="mt-6"
                    >
                        @csrf
                        @method('PATCH')

                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Current progress
                            </span>

                            <select
                                name="status"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:border-brand-primary focus:ring-brand-primary"
                            >
                                @foreach ($statuses as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected(
                                            $order->status === $status
                                        )
                                    >
                                        {{ Str::headline($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <button
                            type="submit"
                            class="mt-4 flex w-full items-center justify-center rounded-2xl bg-brand-primary px-5 py-3.5 text-sm font-black text-slate-950 transition hover:bg-brand-primary-light"
                        >
                            Update Order Status
                        </button>
                    </form>

                    <div class="mt-7 space-y-4 border-t border-slate-200 dark:border-white/10 pt-6">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-500">
                                Subtotal
                            </span>

                            <span class="font-black text-slate-900 dark:text-white">
                                {{ $order->currency }}
                                {{ number_format(
                                    (float) $order->subtotal,
                                    2
                                ) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-600 dark:text-slate-500">
                                Delivery
                            </span>

                            <span class="font-black text-slate-900 dark:text-white">
                                {{ $order->currency }}
                                {{ number_format(
                                    (float) $order->delivery_fee,
                                    2
                                ) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between border-t border-slate-200 dark:border-white/10 pt-5">
                            <span class="font-black text-slate-900 dark:text-white">
                                Total
                            </span>

                            <span class="text-2xl font-black text-brand-primary dark:text-brand-primary-light">
                                {{ $order->currency }}
                                {{ number_format(
                                    (float) $order->total,
                                    2
                                ) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-7 border-t border-slate-200 dark:border-white/10 pt-6">
                        <dl class="space-y-4 text-sm">
                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-600 dark:text-slate-500">
                                    Order method
                                </dt>

                                <dd class="font-black text-slate-900 dark:text-white">
                                    {{ Str::headline(
                                        $order->order_method
                                    ) }}
                                </dd>
                            </div>

                            <div class="flex justify-between gap-4">
                                <dt class="text-slate-600 dark:text-slate-500">
                                    Created
                                </dt>

                                <dd class="text-right font-black text-slate-900 dark:text-white">
                                    {{ $order->created_at->format(
                                        'd M Y, H:i'
                                    ) }}
                                </dd>
                            </div>

                            @if ($order->confirmed_at)
                                <div class="flex justify-between gap-4">
                                    <dt class="text-slate-600 dark:text-slate-500">
                                        Confirmed
                                    </dt>

                                    <dd class="text-right font-black text-slate-900 dark:text-white">
                                        {{ $order->confirmed_at->format(
                                            'd M Y, H:i'
                                        ) }}
                                    </dd>
                                </div>
                            @endif

                            @if ($order->completed_at)
                                <div class="flex justify-between gap-4">
                                    <dt class="text-slate-600 dark:text-slate-500">
                                        Completed
                                    </dt>

                                    <dd class="text-right font-black text-slate-900 dark:text-white">
                                        {{ $order->completed_at->format(
                                            'd M Y, H:i'
                                        ) }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection
