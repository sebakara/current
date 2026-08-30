@extends('admin.layouts.app')

@section('title', $productCategory->name)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Product Category
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $productCategory->name }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    {{ $productCategory->slug }}
                </p>
            </div>

            <a
                href="{{ route(
                    'admin.product-categories.edit',
                    $productCategory
                ) }}"
                class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
            >
                Edit Category
            </a>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7 lg:col-span-2">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Description
                </p>

                <p class="mt-5 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                    {{ $productCategory->description ?: 'No description provided.' }}
                </p>
            </div>

            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                    Summary
                </p>

                <dl class="mt-6 space-y-5">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Products</dt>
                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $productCategory->products_count }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Status</dt>
                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $productCategory->is_active
                                ? 'Active'
                                : 'Inactive' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-slate-600 dark:text-slate-500">Sort order</dt>
                        <dd class="font-black text-slate-900 dark:text-white">
                            {{ $productCategory->sort_order }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection
