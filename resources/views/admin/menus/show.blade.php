@extends('admin.layouts.app')

@section('title', $menu->name)

@section('content')
    <div class="space-y-8">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                    Navigation Menu
                </p>

                <h1 class="mt-3 text-4xl font-black text-slate-900 dark:text-white">
                    {{ $menu->name }}
                </h1>

                <p class="mt-3 text-sm text-slate-600 dark:text-slate-500">
                    Location: {{ $menu->location }}
                </p>
            </div>

            <div class="flex gap-3">
                <a
                    href="{{ route('admin.menus.index') }}"
                    class="rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-3.5 text-sm font-black text-slate-700 dark:text-slate-300"
                >
                    Back
                </a>

                <a
                    href="{{ route(
                        'admin.menus.items.create',
                        $menu
                    ) }}"
                    class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950"
                >
                    + Add Menu Item
                </a>
            </div>
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

        <div class="space-y-4">
            @forelse (
                $menu->allItems
                    ->whereNull('parent_id')
                    ->sortBy('sort_order')
                as $item
            )
                <article class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                        <div>
                            <div class="flex items-center gap-3">
                                <h2 class="text-lg font-black text-slate-900 dark:text-white">
                                    {{ $item->label }}
                                </h2>

                                <span class="rounded-full px-3 py-1 text-xs font-black
                                    {{ $item->is_active
                                        ? 'bg-emerald-400/10 text-emerald-700 dark:text-emerald-300'
                                        : 'bg-slate-100 dark:bg-slate-400/10 text-slate-600 dark:text-slate-400'
                                    }}"
                                >
                                    {{ $item->is_active
                                        ? 'Active'
                                        : 'Inactive' }}
                                </span>
                            </div>

                            <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                                {{ $item->route_name
                                    ?: $item->url
                                    ?: 'Dropdown container' }}
                                · Order {{ $item->sort_order }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a
                                href="{{ route(
                                    'admin.menus.items.edit',
                                    [$menu, $item]
                                ) }}"
                                class="rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-xs font-black text-slate-900 dark:text-white"
                            >
                                Edit
                            </a>

                            <form
                                method="POST"
                                action="{{ route(
                                    'admin.menus.items.destroy',
                                    [$menu, $item]
                                ) }}"
                                onsubmit="return confirm('Delete this link?')"
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
                    </div>

                    @if ($item->children->isNotEmpty())
                        <div class="mt-5 space-y-2 border-l border-slate-200 dark:border-white/10 pl-5">
                            @foreach ($item->children as $child)
                                <div class="flex justify-between gap-4 rounded-xl bg-slate-50 dark:bg-slate-950/70 p-4">
                                    <div>
                                        <p class="font-black text-slate-700 dark:text-slate-300">
                                            {{ $child->label }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $child->route_name
                                                ?: $child->url
                                                ?: '#' }}
                                        </p>
                                    </div>

                                    <div class="flex gap-2">
                                        <a
                                            href="{{ route(
                                                'admin.menus.items.edit',
                                                [$menu, $child]
                                            ) }}"
                                            class="text-xs font-black text-brand-primary dark:text-brand-primary-light"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route(
                                                'admin.menus.items.destroy',
                                                [$menu, $child]
                                            ) }}"
                                            onsubmit="return confirm('Delete this dropdown link?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button class="text-xs font-black text-red-700 dark:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </article>
            @empty
                <div class="rounded-[2rem] border border-dashed border-slate-200 dark:border-white/10 p-16 text-center">
                    <p class="text-xl font-black text-slate-900 dark:text-white">
                        No menu items found
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
