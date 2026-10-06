@php
    $editing = isset($footerLink);
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
                        $footerLink->label ?? ''
                    ) }}"
                    required
                    maxlength="150"
                    placeholder="About Us"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
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
                        $footerLink->route_name ?? ''
                    ) }}"
                    list="footer-route-names"
                    placeholder="about"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <datalist id="footer-route-names">
                    @foreach ($routeNames as $routeName)
                        <option value="{{ $routeName }}">
                    @endforeach
                </datalist>
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
                        $footerLink->url ?? ''
                    ) }}"
                    maxlength="500"
                    placeholder="/about or https://example.com"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    Used only when the route-name field is empty.
                </span>
            </label>
        </div>
    </section>

    <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
        <label class="block">
            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                Target
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
                        $footerLink->target ?? '_self'
                    ) === '_self')
                >
                    Same window
                </option>

                <option
                    value="_blank"
                    @selected(old(
                        'target',
                        $footerLink->target ?? ''
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
                    $footerLink->sort_order ?? 0
                ) }}"
                min="0"
                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
            >
        </label>

        <label class="mt-5 flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
            <span class="text-sm font-black text-slate-900 dark:text-white">
                Active
            </span>

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old(
                    'is_active',
                    $footerLink->is_active ?? true
                ))
                class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
            >
        </label>

        <button
            type="submit"
            class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
        >
            {{ $editing
                ? 'Update Footer Link'
                : 'Create Footer Link' }}
        </button>

        <a
            href="{{ route(
                'admin.footer-sections.show',
                $footerSection
            ) }}"
            class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
        >
            Cancel
        </a>
    </aside>
</div>
