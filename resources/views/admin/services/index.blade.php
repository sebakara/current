@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-heading', 'Services Management')

@section('content')
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                Services
            </h2>

            <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                Manage all services presented on the VTLABS website.
            </p>
        </div>

        <a
            href="{{ route('admin.services.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-5 py-3 text-sm font-black text-white shadow-lg shadow-brand-primary-dark/20 transition hover:-translate-y-0.5"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 5v14M5 12h14"
                />
            </svg>

            Add service
        </a>
    </div>

    <section class="mt-6 rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-5">
        <form
            method="GET"
            class="grid gap-3 lg:grid-cols-[1fr_240px_180px_auto]"
        >
            <div class="relative">
                <svg
                    class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-600 dark:text-slate-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="m21 21-4.3-4.3M19 11a8 8 0 1 1-16 0 8 8 0 0 1 16 0Z"
                    />
                </svg>

                <input
                    name="search"
                    type="search"
                    value="{{ $search }}"
                    placeholder="Search services..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] py-3.5 pl-12 pr-4 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                >
            </div>

            <select
                name="category"
                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
            >
                <option value="">All categories</option>

                @foreach ($categories as $category)
                    <option
                        value="{{ $category->id }}"
                        @selected((string) $categoryId === (string) $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>

            <select
                name="status"
                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
            >
                <option value="">All statuses</option>

                <option
                    value="published"
                    @selected($status === 'published')
                >
                    Published
                </option>

                <option
                    value="draft"
                    @selected($status === 'draft')
                >
                    Draft
                </option>
            </select>

            <div class="flex gap-2">
                <button
                    type="submit"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.05] px-5 py-3 text-sm font-bold text-slate-900 dark:text-white transition hover:bg-slate-100 dark:hover:bg-white/10"
                >
                    Filter
                </button>

                @if ($search || $categoryId || $status)
                    <a
                        href="{{ route('admin.services.index') }}"
                        class="rounded-2xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-bold text-slate-600 dark:text-slate-400 transition hover:text-slate-900 dark:hover:text-white"
                    >
                        Clear
                    </a>
                @endif
            </div>
        </form>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($services as $service)
            <article class="group overflow-hidden rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 transition duration-300 hover:-translate-y-1 hover:border-brand-primary/20">
                <div class="relative h-48 overflow-hidden bg-white dark:bg-slate-900">
                    @if ($service->featured_image)
                        <img
                            src="{{ Storage::url($service->featured_image) }}"
                            alt="{{ $service->title }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                    @else
                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 to-brand-secondary/5">
                            <span class="text-5xl font-black text-slate-700 dark:text-white/10">
                                {{ strtoupper(substr($service->title, 0, 2)) }}
                            </span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>

                    <div class="absolute left-4 top-4 flex flex-wrap gap-2">
                        <span class="rounded-full border px-3 py-1 text-[10px] font-black uppercase tracking-wider {{ $service->is_published
                            ? 'border-emerald-400/20 bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                            : 'border-amber-400/20 bg-amber-400/10 text-amber-700 dark:text-amber-300' }}">
                            {{ $service->is_published ? 'Published' : 'Draft' }}
                        </span>

                        @if ($service->is_featured)
                            <span class="rounded-full border border-brand-primary/20 bg-brand-primary/10 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-brand-primary dark:text-brand-primary-light">
                                Featured
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.14em] text-brand-primary">
                        {{ $service->category?->name ?? 'Uncategorized' }}
                    </p>

                    <h3 class="mt-2 text-lg font-black text-slate-900 dark:text-white">
                        {{ $service->title }}
                    </h3>

                    <p class="mt-3 line-clamp-3 min-h-[4.5rem] text-sm leading-6 text-slate-600 dark:text-slate-500">
                        {{ $service->short_description ?: 'No short description has been added.' }}
                    </p>

                    <div class="mt-4 flex items-center justify-between text-xs text-slate-600 dark:text-slate-600">
                        <span>Order: {{ $service->sort_order }}</span>
                        <span>{{ number_format($service->views) }} views</span>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2 border-t border-slate-200 dark:border-white/10 pt-4">
                        <a
                            href="{{ route('admin.services.edit', $service) }}"
                            class="rounded-xl bg-brand-primary/10 px-3 py-2.5 text-center text-xs font-black text-brand-primary dark:text-brand-primary-light transition hover:bg-brand-primary/20"
                        >
                            Edit
                        </a>


 <a
        href="{{ route('admin.services.show', $service) }}"
        class="rounded-xl border border-slate-200 dark:border-white/10 px-3 py-2.5 text-center text-xs font-bold text-slate-600 dark:text-slate-400 transition hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white"
    >
        View
    </a>


                        <form
                            method="POST"
                            action="{{ route(
                                'admin.services.toggle-publish',
                                $service
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="w-full rounded-xl border border-slate-200 dark:border-white/10 px-3 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 transition hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white"
                            >
                                {{ $service->is_published
                                    ? 'Unpublish'
                                    : 'Publish' }}
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.services.toggle-featured',
                                $service
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="w-full rounded-xl border border-slate-200 dark:border-white/10 px-3 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 transition hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white"
                            >
                                {{ $service->is_featured
                                    ? 'Unfeature'
                                    : 'Feature' }}
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.services.destroy',
                                $service
                            ) }}"
                            onsubmit="return confirm('Delete this service?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-full rounded-xl border border-red-400/10 px-3 py-2.5 text-xs font-bold text-red-400 transition hover:bg-red-400/10"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/40 px-6 py-16 text-center md:col-span-2 xl:col-span-3">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-50 dark:bg-white/5">
                    <svg
                        class="h-8 w-8 text-slate-600 dark:text-slate-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 3l2 4 4 .5-3 3 .8 4.5L12 13l-3.8 2 .8-4.5-3-3L10 7l2-4Z"
                        />
                    </svg>
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-900 dark:text-white">
                    No services found
                </h3>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                    Add the first VTLABS service to the website.
                </p>

                <a
                    href="{{ route('admin.services.create') }}"
                    class="mt-6 inline-flex rounded-2xl bg-brand-primary px-5 py-3 text-sm font-black text-slate-950"
                >
                    Create first service
                </a>
            </div>
        @endforelse
    </section>

    @if ($services->hasPages())
        <div class="mt-6">
            {{ $services->links() }}
        </div>
    @endif
@endsection
