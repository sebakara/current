@php
    $editing = isset($menuItem);
@endphp

@if ($errors->any())
    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
        <ul class="list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-8 xl:grid-cols-[1fr_360px]">
    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
        <div class="space-y-6">
            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Link label *
                </span>

                <input
                    type="text"
                    name="label"
                    value="{{ old(
                        'label',
                        $menuItem->label ?? ''
                    ) }}"
                    required
                    maxlength="150"
                    placeholder="About Us"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Parent item
                </span>

                <select
                    name="parent_id"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
                    <option value="">Top-level item</option>

                    @foreach ($parents as $parent)
                        <option
                            value="{{ $parent->id }}"
                            @selected(
                                old(
                                    'parent_id',
                                    $menuItem->parent_id ?? ''
                                ) == $parent->id
                            )
                        >
                            {{ $parent->label }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Laravel route name
                </span>

                <input
                    type="text"
                    name="route_name"
                    value="{{ old(
                        'route_name',
                        $menuItem->route_name ?? ''
                    ) }}"
                    list="public-route-names"
                    placeholder="about"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <datalist id="public-route-names">
                    @foreach ($routeNames as $routeName)
                        <option value="{{ $routeName }}">
                    @endforeach
                </datalist>

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    Recommended for internal website pages.
                </span>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Custom URL
                </span>

                <input
                    type="text"
                    name="url"
                    value="{{ old(
                        'url',
                        $menuItem->url ?? ''
                    ) }}"
                    maxlength="500"
                    placeholder="/about or https://example.com"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    Used only when the route-name field is empty.
                </span>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Icon
                </span>

                <input
                    type="text"
                    name="icon"
                    value="{{ old(
                        'icon',
                        $menuItem->icon ?? ''
                    ) }}"
                    maxlength="200"
                    placeholder="Optional icon class or identifier"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>
        </div>
    </section>

    <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
        <label class="block">
            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                Link target
            </span>

            <select
                name="target"
                required
                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
            >
                <option
                    value="_self"
                    @selected(old(
                        'target',
                        $menuItem->target ?? '_self'
                    ) === '_self')
                >
                    Same window
                </option>

                <option
                    value="_blank"
                    @selected(old(
                        'target',
                        $menuItem->target ?? ''
                    ) === '_blank')
                >
                    New window
                </option>
            </select>
        </label>

        <label class="mt-5 block">
            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                Sort order
            </span>

            <input
                type="number"
                name="sort_order"
                value="{{ old(
                    'sort_order',
                    $menuItem->sort_order ?? 0
                ) }}"
                min="0"
                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
            >
        </label>

        <label class="mt-5 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
            <span class="text-sm font-black text-slate-900 dark:text-white">
                Active
            </span>

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old(
                    'is_active',
                    $menuItem->is_active ?? true
                ))
                class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
            >
        </label>

        <button
            type="submit"
            class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
        >
            {{ $editing
                ? 'Update Menu Item'
                : 'Create Menu Item' }}
        </button>

        <a
            href="{{ route('admin.menus.show', $menu) }}"
            class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
        >
            Cancel
        </a>
    </aside>
</div>
