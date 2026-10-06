@php
    $editing = isset($menu);
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
        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
            Menu Information
        </p>

        <div class="mt-6 space-y-6">
            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Menu name *
                </span>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $menu->name ?? '') }}"
                    required
                    maxlength="150"
                    placeholder="Main Navigation"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Menu location *
                </span>

                <select
                    name="location"
                    required
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
                    <option value="">Select location</option>

                    @foreach ([
                        'header' => 'Header Navigation',
                        'mobile' => 'Mobile Navigation',
                        'footer' => 'Footer Navigation',
                        'sidebar' => 'Sidebar Navigation',
                        'academy' => 'Academy Navigation',
                    ] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected(
                                old(
                                    'location',
                                    $menu->location ?? ''
                                ) === $value
                            )
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </label>
        </div>
    </section>

    <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
            Settings
        </p>

        <label class="mt-6 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
            <span>
                <span class="block text-sm font-black text-slate-900 dark:text-white">
                    Active
                </span>

                <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                    Allow this menu to appear on the website.
                </span>
            </span>

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old(
                    'is_active',
                    $menu->is_active ?? true
                ))
                class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
            >
        </label>

        <button
            type="submit"
            class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
        >
            {{ $editing ? 'Update Menu' : 'Create Menu' }}
        </button>

        <a
            href="{{ route('admin.menus.index') }}"
            class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
        >
            Cancel
        </a>
    </aside>
</div>
