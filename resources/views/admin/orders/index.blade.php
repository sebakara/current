@extends('admin.layouts.app')

@section('title', 'Orders')

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
    @endphp

    <div class="space-y-8">
        {{-- Page heading --}}
        <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-center">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Ecommerce
                </p>

                <h1 class="mt-2 text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                    Customer Orders
                </h1>

                <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-500">
                    Review customer orders, update progress, and contact buyers.
                </p>
            </div>

            <a
                href="{{ route('products') }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-5 py-3 text-sm font-black text-slate-900 dark:text-white transition hover:border-brand-primary/20 hover:bg-brand-primary/10 hover:text-brand-primary dark:hover:text-brand-primary-light"
            >
                View Product Shop
                <span>↗</span>
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-bold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Summary cards --}}
        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">
            <div class="rounded-[1.7rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-5">
                <p class="text-xs font-black uppercase tracking-[0.15em] text-slate-600 dark:text-slate-500">
                    Total Orders
                </p>

                <p class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    {{ number_format($summary['total_orders']) }}
                </p>
            </div>

            <div class="rounded-[1.7rem] border border-amber-400/10 bg-amber-400/[0.04] p-5">
                <p class="text-xs font-black uppercase tracking-[0.15em] text-amber-400">
                    Pending
                </p>

                <p class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    {{ number_format($summary['pending_orders']) }}
                </p>
            </div>

            <div class="rounded-[1.7rem] border border-violet-400/10 bg-violet-400/[0.04] p-5">
                <p class="text-xs font-black uppercase tracking-[0.15em] text-violet-400">
                    In Progress
                </p>

                <p class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    {{ number_format($summary['processing_orders']) }}
                </p>
            </div>

            <div class="rounded-[1.7rem] border border-emerald-400/10 bg-emerald-400/[0.04] p-5">
                <p class="text-xs font-black uppercase tracking-[0.15em] text-emerald-400">
                    Completed
                </p>

                <p class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                    {{ number_format($summary['completed_orders']) }}
                </p>
            </div>

            <div class="rounded-[1.7rem] border border-brand-primary/10 bg-brand-primary/[0.04] p-5">
                <p class="text-xs font-black uppercase tracking-[0.15em] text-brand-primary">
                    Completed Sales
                </p>

                <p class="mt-4 text-xl font-black text-slate-900 dark:text-white">
                    RWF {{ number_format(
                        (float) $summary['total_sales'],
                        0
                    ) }}
                </p>
            </div>
        </div>

        {{-- Filters --}}
        <form
            action="{{ route('admin.orders.index') }}"
            method="GET"
            class="grid gap-4 rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-5 lg:grid-cols-[1fr_220px_200px_auto]"
        >
            <label>
                <span class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                    Search
                </span>

                <input
                    type="search"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Order number, customer, phone..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-700 focus:border-brand-primary focus:ring-brand-primary"
                >
            </label>

            <label>
                <span class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                    Status
                </span>

                <select
                    name="status"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:border-brand-primary focus:ring-brand-primary"
                >
                    <option value="">All statuses</option>

                    @foreach ([
                        'pending',
                        'confirmed',
                        'processing',
                        'ready',
                        'completed',
                        'cancelled',
                    ] as $statusOption)
                        <option
                            value="{{ $statusOption }}"
                            @selected($status === $statusOption)
                        >
                            {{ Str::headline($statusOption) }}
                            ({{ $statusCounts[$statusOption] ?? 0 }})
                        </option>
                    @endforeach
                </select>
            </label>

            <label>
                <span class="mb-2 block text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                    Method
                </span>

                <select
                    name="method"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-sm text-slate-900 dark:text-white focus:border-brand-primary focus:ring-brand-primary"
                >
                    <option value="">All methods</option>

                    <option
                        value="whatsapp"
                        @selected($method === 'whatsapp')
                    >
                        WhatsApp
                    </option>

                    <option
                        value="website"
                        @selected($method === 'website')
                    >
                        Website
                    </option>
                </select>
            </label>

            <div class="flex items-end gap-2">
                <button
                    type="submit"
                    class="flex-1 rounded-2xl bg-brand-primary px-5 py-3.5 text-sm font-black text-slate-950 transition hover:bg-brand-primary-light"
                >
                    Filter
                </button>

                <a
                    href="{{ route('admin.orders.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300 transition hover:bg-slate-100 dark:hover:bg-white/[0.08]"
                >
                    Reset
                </a>
            </div>
        </form>

        {{-- Orders table --}}
        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-white/10">
                    <thead class="bg-slate-50 dark:bg-white/[0.025]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Order
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Customer
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Items
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Total
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-[0.14em] text-slate-600 dark:text-slate-500">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-white/10">
                        @forelse ($orders as $order)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="whitespace-nowrap px-6 py-5">
                                    <a
                                        href="{{ route(
                                            'admin.orders.show',
                                            $order
                                        ) }}"
                                        class="font-black text-slate-900 dark:text-white transition hover:text-brand-primary dark:hover:text-brand-primary-light"
                                    >
                                        {{ $order->order_number }}
                                    </a>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $order->created_at->format(
                                            'd M Y, H:i'
                                        ) }}
                                    </p>

                                    <p class="mt-1 text-[10px] font-black uppercase tracking-wider text-emerald-400">
                                        {{ Str::headline(
                                            $order->order_method
                                        ) }}
                                    </p>
                                </td>

                                <td class="px-6 py-5">
                                    <p class="font-bold text-slate-700 dark:text-slate-200">
                                        {{ $order->customer_name }}
                                    </p>

                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                                        {{ $order->customer_phone }}
                                    </p>

                                    @if ($order->customer_email)
                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $order->customer_email }}
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <span class="rounded-full border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-1.5 text-xs font-black text-slate-700 dark:text-slate-300">
                                        {{ $order->items_count }}
                                        {{ Str::plural(
                                            'item',
                                            $order->items_count
                                        ) }}
                                    </span>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $order->currency }}
                                        {{ number_format(
                                            (float) $order->total,
                                            2
                                        ) }}
                                    </p>
                                </td>

                                <td class="whitespace-nowrap px-6 py-5">
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
                                </td>

                                <td class="whitespace-nowrap px-6 py-5 text-right">
                                    <a
                                        href="{{ route(
                                            'admin.orders.show',
                                            $order
                                        ) }}"
                                        class="inline-flex rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-2.5 text-sm font-black text-slate-900 dark:text-white transition hover:border-brand-primary/20 hover:bg-brand-primary/10 hover:text-brand-primary dark:hover:text-brand-primary-light"
                                    >
                                        View Order
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >
                                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-brand-primary/10 text-2xl">
                                        🛒
                                    </div>

                                    <h2 class="mt-5 text-xl font-black text-slate-900 dark:text-white">
                                        No orders found
                                    </h2>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                                        Customer orders will appear here.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="border-t border-slate-200 dark:border-white/10 px-6 py-5">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
