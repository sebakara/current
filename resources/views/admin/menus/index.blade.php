@extends('admin.layouts.app')

@section('title', 'Menus')

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Navigation
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    Menus
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Manage website navigation menus and dropdown links.
                </p>
            </div>

            <a
                href="{{ route('admin.menus.create') }}"
                class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-3.5 text-sm font-black text-white"
            >
                + New Menu
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-red-700 dark:text-red-300">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($menus as $menu)
                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-xl font-black text-slate-900 dark:text-white">
                                {{ $menu->name }}
                            </h2>

                            <p class="mt-2 text-sm text-brand-primary dark:text-brand-primary-light">
                                {{ str($menu->location)
                                    ->replace('-', ' ')
                                    ->title() }}
                            </p>
                        </div>

                        <span class="rounded-full px-3 py-1.5 text-xs font-black
                            {{ $menu->is_active
                                ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                            }}"
                        >
                            {{ $menu->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <p class="mt-5 text-sm text-slate-600 dark:text-slate-500">
                        {{ $menu->all_items_count }}
                        navigation links
                    </p>

                    <div class="mt-6 flex gap-2">
                        <a
                            href="{{ route('admin.menus.show', $menu) }}"
                            class="flex-1 rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-center text-xs font-black text-slate-900 dark:text-white"
                        >
                            Manage Links
                        </a>

                        <a
                            href="{{ route('admin.menus.edit', $menu) }}"
                            class="rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-xs font-black text-slate-700 dark:text-slate-300"
                        >
                            Edit
                        </a>

                        <form
                            method="POST"
                            action="{{ route(
                                'admin.menus.destroy',
                                $menu
                            ) }}"
                            onsubmit="return confirm('Delete this menu?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button
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
                        No menus found
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
