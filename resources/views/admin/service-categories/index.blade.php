@extends('admin.layouts.app')

@section('title', 'Service Categories')
@section('page-heading', 'Service Categories')

@section('content')
    <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-center">
        <div>
            <h2 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">
                Service Categories
            </h2>

            <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                Organize VTLABS services into clear website categories.
            </p>
        </div>

        <a
            href="{{ route('admin.service-categories.create') }}"
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

            Add category
        </a>
    </div>

    <section class="mt-6 rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-5">
        <form method="GET" class="flex flex-col gap-3 sm:flex-row">
            <div class="relative flex-1">
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
                    placeholder="Search categories..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] py-3.5 pl-12 pr-4 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                >
            </div>

            <button
                type="submit"
                class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.05] px-5 py-3 text-sm font-bold text-slate-900 dark:text-white transition hover:bg-slate-100 dark:hover:bg-white/10"
            >
                Search
            </button>

            @if ($search)
                <a
                    href="{{ route('admin.service-categories.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-bold text-slate-600 dark:text-slate-400 transition hover:text-slate-900 dark:hover:text-white"
                >
                    Clear
                </a>
            @endif
        </form>
    </section>

    <section class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($categories as $category)
            <article class="group overflow-hidden rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 transition duration-300 hover:-translate-y-1 hover:border-brand-primary/20">
                <div class="relative h-44 overflow-hidden bg-white dark:bg-slate-900">
                    @if ($category->image)
                        <img
                            src="{{ Storage::url($category->image) }}"
                            alt="{{ $category->name }}"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                        >
                    @else
                        <div class="flex h-full items-center justify-center bg-gradient-to-br from-brand-primary-dark/10 to-brand-secondary/5">
                            <span class="text-4xl font-black text-slate-700 dark:text-white/10">
                                {{ strtoupper(substr($category->name, 0, 2)) }}
                            </span>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-white dark:from-slate-950 via-transparent to-transparent"></div>

                    <span class="absolute right-4 top-4 rounded-full border px-3 py-1 text-[10px] font-black uppercase tracking-wider {{ $category->is_active
                        ? 'border-emerald-400/20 bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                        : 'border-slate-300 dark:border-slate-400/20 bg-white dark:bg-slate-800/80 text-slate-600 dark:text-slate-400' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white">
                                {{ $category->name }}
                            </h3>

                            <p class="mt-1 text-xs font-semibold text-brand-primary">
                                {{ $category->services_count }}
                                {{ Str::plural('service', $category->services_count) }}
                            </p>
                        </div>

                        <span class="rounded-xl bg-slate-50 dark:bg-white/5 px-2.5 py-1 text-xs font-bold text-slate-600 dark:text-slate-500">
                            #{{ $category->sort_order }}
                        </span>
                    </div>

                    <p class="mt-4 line-clamp-3 min-h-[4.5rem] text-sm leading-6 text-slate-600 dark:text-slate-500">
                        {{ $category->description ?: 'No category description has been added.' }}
                    </p>

                    <div class="mt-5 flex items-center gap-2 border-t border-slate-200 dark:border-white/10 pt-4">
                        <a
                            href="{{ route(
                                'admin.service-categories.edit',
                                $category
                            ) }}"
                            class="flex-1 rounded-xl bg-brand-primary/10 px-3 py-2.5 text-center text-xs font-black text-brand-primary dark:text-brand-primary-light transition hover:bg-brand-primary/20"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.service-categories.toggle-status',
                                $category
                            ) }}"
                        >
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="rounded-xl border border-slate-200 dark:border-white/10 px-3 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-400 transition hover:bg-slate-100 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white"
                            >
                                {{ $category->is_active ? 'Disable' : 'Enable' }}
                            </button>
                        </form>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.service-categories.destroy',
                                $category
                            ) }}"
                            onsubmit="return confirm('Delete this category?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl border border-red-400/10 px-3 py-2.5 text-xs font-bold text-red-400 transition hover:bg-red-400/10"
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
                            d="M4 21V9l5 3V9l5 3V5h6v16H4Z"
                        />
                    </svg>
                </div>

                <h3 class="mt-5 text-lg font-black text-slate-900 dark:text-white">
                    No service categories found
                </h3>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-500">
                    Create the first category for VTLABS services.
                </p>
            </div>
        @endforelse
    </section>

    @if ($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
@endsection
