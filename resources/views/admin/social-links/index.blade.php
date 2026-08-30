@extends('admin.layouts.app')

@section('title', 'Social Links')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Website Profiles
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    Social Links
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Manage social-media profiles displayed on the website.
                </p>
            </div>

            <a
                href="{{ route('admin.social-links.create') }}"
                class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Social Link
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[1fr_200px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search platform, URL, or icon..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="all" @selected($status === 'all')>
                    All links
                </option>

                <option value="active" @selected($status === 'active')>
                    Active
                </option>

                <option
                    value="inactive"
                    @selected($status === 'inactive')
                >
                    Inactive
                </option>
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.social-links.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($links as $link)
                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                                {{ $link->icon ?: 'Social profile' }}
                            </p>

                            <h2 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                {{ $link->platform }}
                            </h2>
                        </div>

                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                            {{ $link->is_active
                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                            }}"
                        >
                            {{ $link->is_active
                                ? 'Active'
                                : 'Inactive' }}
                        </span>
                    </div>

                    <p class="mt-4 break-all text-sm leading-7 text-slate-600 dark:text-slate-500">
                        {{ $link->url }}
                    </p>

                    <p class="mt-3 text-xs text-slate-600 dark:text-slate-600">
                        Order {{ $link->sort_order }}
                    </p>

                    <div class="mt-6 flex gap-2">
                        <a
                            href="{{ route(
                                'admin.social-links.show',
                                $link
                            ) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-700 dark:text-slate-300"
                        >
                            View
                        </a>

                        <a
                            href="{{ route(
                                'admin.social-links.edit',
                                $link
                            ) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-900 dark:text-white"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.social-links.destroy',
                                $link
                            ) }}"
                            onsubmit="return confirm('Delete this social link?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl border border-red-400/15 px-4 py-2.5 text-xs font-black text-red-700 dark:text-red-300"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No social links found
                    </p>
                </div>
            @endforelse
        </div>

        {{ $links->links() }}
    </div>
@endsection@extends('admin.layouts.app')

@section('title', 'Social Links')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Website Profiles
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    Social Links
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Manage social-media profiles displayed on the website.
                </p>
            </div>

            <a
                href="{{ route('admin.social-links.create') }}"
                class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Social Link
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        <form
            method="GET"
            class="grid gap-3 rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-4 md:grid-cols-[1fr_200px_auto_auto]"
        >
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search platform, URL, or icon..."
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >

            <select
                name="status"
                class="rounded-xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3 text-slate-900 dark:text-white"
            >
                <option value="all" @selected($status === 'all')>
                    All links
                </option>

                <option value="active" @selected($status === 'active')>
                    Active
                </option>

                <option
                    value="inactive"
                    @selected($status === 'inactive')
                >
                    Inactive
                </option>
            </select>

            <button
                type="submit"
                class="rounded-xl bg-slate-50 dark:bg-white/[0.07] px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
            >
                Filter
            </button>

            <a
                href="{{ route('admin.social-links.index') }}"
                class="rounded-xl border border-slate-200 dark:border-white/10 px-5 py-3 text-center text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Reset
            </a>
        </form>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($links as $link)
                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs font-black uppercase tracking-wider text-brand-primary">
                                {{ $link->icon ?: 'Social profile' }}
                            </p>

                            <h2 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                {{ $link->platform }}
                            </h2>
                        </div>

                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                            {{ $link->is_active
                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                            }}"
                        >
                            {{ $link->is_active
                                ? 'Active'
                                : 'Inactive' }}
                        </span>
                    </div>

                    <p class="mt-4 break-all text-sm leading-7 text-slate-600 dark:text-slate-500">
                        {{ $link->url }}
                    </p>

                    <p class="mt-3 text-xs text-slate-600 dark:text-slate-600">
                        Order {{ $link->sort_order }}
                    </p>

                    <div class="mt-6 flex gap-2">
                        <a
                            href="{{ route(
                                'admin.social-links.show',
                                $link
                            ) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-700 dark:text-slate-300"
                        >
                            View
                        </a>

                        <a
                            href="{{ route(
                                'admin.social-links.edit',
                                $link
                            ) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-900 dark:text-white"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.social-links.destroy',
                                $link
                            ) }}"
                            onsubmit="return confirm('Delete this social link?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="rounded-xl border border-red-400/15 px-4 py-2.5 text-xs font-black text-red-700 dark:text-red-300"
                            >
                                Delete
                            </button>
                        </form>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No social links found
                    </p>
                </div>
            @endforelse
        </div>

        {{ $links->links() }}
    </div>
@endsection
