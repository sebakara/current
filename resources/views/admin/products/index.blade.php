@extends('admin.layouts.app')

@section('title', 'Products')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Product Catalogue
                </p>

                <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                    Products
                </h1>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Manage catalogue content, pricing, inventory, options, and ordering.
                </p>
            </div>

            <a
                href="{{ route('admin.products.create') }}"
                class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Product
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[1fr_230px_180px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search name, SKU, or description..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="category"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="">All categories</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected($categoryId === $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                @foreach ([
                    'all' => 'All products',
                    'published' => 'Published',
                    'draft' => 'Draft',
                    'featured' => 'Featured',
                    'out-of-stock' => 'Out of stock',
                ] as $value => $label)
                    <option
                        value="{{ $value }}"
                        @selected($status === $value)
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.products.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025]">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Product
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Price
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Stock
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-600 dark:text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-white/[0.07]">
                        @forelse ($products as $product)
                            <tr class="transition hover:bg-slate-100 dark:hover:bg-white/[0.02]">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                            @if (
                                                $product->featured_image
                                                && Storage::disk('public')->exists($product->featured_image)
                                            )
                                                <img
                                                    src="{{ Storage::url($product->featured_image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-full w-full object-cover"
                                                >
                                            @else
                                                <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                                    {{ strtoupper(substr($product->name, 0, 2)) }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="min-w-0">
                                            <p class="max-w-xs truncate font-black text-slate-900 dark:text-white">
                                                {{ $product->name }}
                                            </p>

                                            <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                                {{ $product->sku ?: $product->slug }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-5 text-sm text-slate-600 dark:text-slate-400">
                                    {{ $product->category?->name ?: 'Uncategorised' }}
                                </td>

                                <td class="px-6 py-5">
                                    @if ($product->current_price !== null)
                                        <p class="font-black text-slate-900 dark:text-white">
                                            {{ $product->currency }}
                                            {{ number_format($product->current_price, 2) }}
                                        </p>

                                        @if (!$product->show_price)
                                            <p class="mt-1 text-xs text-amber-700 dark:text-amber-300">
                                                Hidden publicly
                                            </p>
                                        @endif
                                    @else
                                        <span class="text-sm font-black text-brand-primary dark:text-brand-primary-light">
                                            On request
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    @if (!$product->manage_stock)
                                        <span class="text-sm text-slate-600 dark:text-slate-500">
                                            Not tracked
                                        </span>
                                    @elseif ($product->stock_quantity > 0)
                                        <span class="text-sm font-black text-emerald-700 dark:text-emerald-300">
                                            {{ number_format($product->stock_quantity) }}
                                        </span>
                                    @elseif ($product->allow_backorders)
                                        <span class="text-sm font-black text-amber-700 dark:text-amber-300">
                                            Backorder
                                        </span>
                                    @else
                                        <span class="text-sm font-black text-red-700 dark:text-red-300">
                                            Out of stock
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                                            {{ $product->is_published
                                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                            }}"
                                        >
                                            {{ $product->is_published
                                                ? 'Published'
                                                : 'Draft' }}
                                        </span>

                                        @if ($product->is_featured)
                                            <span class="rounded-full bg-brand-primary/10 px-3 py-1.5 text-xs font-black text-brand-primary dark:text-brand-primary-light">
                                                Featured
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-5">
                                    <div class="flex justify-end gap-2">
                                        @if ($product->is_published)
                                            <a
                                                href="{{ route('products.show', $product) }}"
                                                target="_blank"
                                                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-3 py-2 text-xs font-black text-slate-700 dark:text-slate-300"
                                            >
                                                View
                                            </a>
                                        @endif

                                        <a
                                            href="{{ route('admin.products.edit', $product) }}"
                                            class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-3 py-2 text-xs font-black text-slate-900 dark:text-white"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.products.destroy', $product) }}"
                                            onsubmit="return confirm('Delete this product?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-xl border border-red-400/15 bg-red-400/[0.06] px-3 py-2 text-xs font-black text-red-700 dark:text-red-300"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="6"
                                    class="px-6 py-16 text-center"
                                >
                                    <p class="text-lg font-black text-slate-900 dark:text-white">
                                        No products found
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                        Create your first product or adjust the filters.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{ $products->links() }}
    </div>
@endsection
