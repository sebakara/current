@extends('admin.layouts.app')

@section('title', $product->name)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Product Details
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $product->name }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $product->sku ?: $product->slug }}
                </p>
            </div>

            <div class="flex gap-3">
                @if ($product->is_published)
                    <a
                        href="{{ route('products.show', $product) }}"
                        target="_blank"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white"
                    >
                        View Public Page
                    </a>
                @endif

                <a
                    href="{{ route('admin.products.edit', $product) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    Edit Product
                </a>
            </div>
        </div>

        <div class="grid gap-7 lg:grid-cols-[1fr_350px]">
            <div class="space-y-7">
                @if (
                    $product->featured_image
                    && Storage::disk('public')->exists($product->featured_image)
                )
                    <img
                        src="{{ Storage::url($product->featured_image) }}"
                        alt="{{ $product->name }}"
                        class="h-[440px] w-full rounded-[2rem] border border-slate-200 dark:border-white/10 object-cover"
                    >
                @endif

                <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Description
                    </p>

                    <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $product->description ?: 'No full description provided.' }}
                    </p>
                </div>

                @if (collect($product->features)->isNotEmpty())
                    <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Features
                        </p>

                        <ul class="mt-5 space-y-3">
                            @foreach ($product->features as $feature)
                                <li class="flex gap-3 text-sm text-slate-600 dark:text-slate-400">
                                    <span class="text-brand-primary dark:text-brand-primary-light">✓</span>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <aside class="space-y-7">
                <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                    <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                        Summary
                    </p>

                    <dl class="mt-6 space-y-5">
                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Category</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                {{ $product->category?->name }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Price</dt>
                            <dd class="text-right font-black text-slate-900 dark:text-white">
                                @if ($product->current_price !== null)
                                    {{ $product->currency }}
                                    {{ number_format($product->current_price, 2) }}
                                @else
                                    On request
                                @endif
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Published</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ $product->is_published ? 'Yes' : 'No' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Cart enabled</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ $product->cart_enabled ? 'Yes' : 'No' }}
                            </dd>
                        </div>

                        <div class="flex justify-between gap-4">
                            <dt class="text-sm text-slate-600 dark:text-slate-500">Views</dt>
                            <dd class="font-black text-slate-900 dark:text-white">
                                {{ number_format($product->views) }}
                            </dd>
                        </div>
                    </dl>
                </div>

                @if (collect($product->options)->isNotEmpty())
                    <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
                        <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                            Product Options
                        </p>

                        <div class="mt-5 space-y-5">
                            @foreach ($product->options as $option)
                                <div>
                                    <p class="text-sm font-black text-slate-900 dark:text-white">
                                        {{ data_get($option, 'name') }}
                                    </p>

                                    <p class="mt-2 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                        {{ collect(data_get($option, 'values', []))->implode(', ') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>
    </div>
@endsection
