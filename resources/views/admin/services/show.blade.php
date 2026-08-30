@extends('admin.layouts.app')

@section('title', $service->title)
@section('page-heading', 'Service Preview')

@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <a
                href="{{ route('admin.services.index') }}"
                class="text-sm font-bold text-slate-600 dark:text-slate-500 transition hover:text-brand-primary"
            >
                ← Back to services
            </a>

            <h2 class="mt-4 text-3xl font-black text-slate-900 dark:text-white">
                {{ $service->title }}
            </h2>

            <p class="mt-2 text-sm text-brand-primary">
                {{ $service->category?->name ?? 'Uncategorized' }}
            </p>
        </div>

        <a
            href="{{ route('admin.services.edit', $service) }}"
            class="inline-flex items-center justify-center rounded-2xl bg-brand-primary px-5 py-3 text-sm font-black text-slate-950"
        >
            Edit service
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            @if ($service->featured_image)
                <img
                    src="{{ Storage::url($service->featured_image) }}"
                    alt="{{ $service->title }}"
                    class="h-80 w-full rounded-3xl border border-slate-200 dark:border-white/10 object-cover"
                >
            @endif

            <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
                <h3 class="text-lg font-black text-slate-900 dark:text-white">
                    Description
                </h3>

                <div class="mt-4 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                    {{ $service->description ?: 'No detailed description has been added.' }}
                </div>
            </section>

            <section class="grid gap-6 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">
                        Benefits
                    </h3>

                    <div class="mt-4 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $service->benefits ?: 'No benefits have been added.' }}
                    </div>
                </div>

                <div class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">
                        Process
                    </h3>

                    <div class="mt-4 whitespace-pre-line text-sm leading-8 text-slate-600 dark:text-slate-400">
                        {{ $service->process ?: 'No process has been added.' }}
                    </div>
                </div>
            </section>
        </div>

        <div class="space-y-6">
            <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
                <h3 class="text-lg font-black text-slate-900 dark:text-white">
                    Publishing details
                </h3>

                <dl class="mt-5 space-y-4 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-600 dark:text-slate-500">Status</dt>
                        <dd class="font-bold text-slate-900 dark:text-white">
                            {{ $service->is_published ? 'Published' : 'Draft' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-600 dark:text-slate-500">Featured</dt>
                        <dd class="font-bold text-slate-900 dark:text-white">
                            {{ $service->is_featured ? 'Yes' : 'No' }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-600 dark:text-slate-500">Display order</dt>
                        <dd class="font-bold text-slate-900 dark:text-white">
                            {{ $service->sort_order }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-600 dark:text-slate-500">Views</dt>
                        <dd class="font-bold text-slate-900 dark:text-white">
                            {{ number_format($service->views) }}
                        </dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
                <h3 class="text-lg font-black text-slate-900 dark:text-white">
                    SEO
                </h3>

                <div class="mt-5 space-y-4">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-600">
                            Meta title
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-700 dark:text-slate-300">
                            {{ $service->meta_title ?: 'Not configured' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-600">
                            Meta description
                        </p>

                        <p class="mt-2 text-sm leading-6 text-slate-700 dark:text-slate-300">
                            {{ $service->meta_description ?: 'Not configured' }}
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
