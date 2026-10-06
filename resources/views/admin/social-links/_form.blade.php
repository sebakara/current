@php
    $editing = isset($socialLink);
@endphp

@if ($errors->any())
    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
        <p class="font-black text-red-700 dark:text-red-300">
            Please correct the following errors:
        </p>

        <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-8 xl:grid-cols-[1fr_360px]">
    <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
            Social Profile
        </p>

        <div class="mt-6 space-y-6">
            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Platform *
                </span>

                <select
                    name="platform"
                    required
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
                    <option value="">Select platform</option>

                    @foreach ([
                        'Facebook',
                        'Instagram',
                        'LinkedIn',
                        'TikTok',
                        'YouTube',
                        'X',
                        'WhatsApp',
                        'Telegram',
                        'GitHub',
                    ] as $platform)
                        <option
                            value="{{ $platform }}"
                            @selected(
                                old(
                                    'platform',
                                    $socialLink->platform ?? ''
                                ) === $platform
                            )
                        >
                            {{ $platform }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Profile URL *
                </span>

                <input
                    type="url"
                    name="url"
                    value="{{ old(
                        'url',
                        $socialLink->url ?? ''
                    ) }}"
                    required
                    maxlength="500"
                    placeholder="https://..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Icon identifier
                </span>

                <input
                    type="text"
                    name="icon"
                    value="{{ old(
                        'icon',
                        $socialLink->icon ?? ''
                    ) }}"
                    maxlength="200"
                    placeholder="fab fa-instagram"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                    Use the icon class or identifier expected by the frontend.
                </span>
            </label>
        </div>
    </section>

    <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
            Display Settings
        </p>

        <label class="mt-6 block">
            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                Sort order
            </span>

            <input
                type="number"
                name="sort_order"
                value="{{ old(
                    'sort_order',
                    $socialLink->sort_order ?? 0
                ) }}"
                min="0"
                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
            >
        </label>

        <label class="mt-5 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
            <span>
                <span class="block text-sm font-black text-slate-900 dark:text-white">
                    Active
                </span>

                <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                    Display this social profile on the website.
                </span>
            </span>

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old(
                    'is_active',
                    $socialLink->is_active ?? true
                ))
                class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
            >
        </label>

        <button
            type="submit"
            class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
        >
            {{ $editing
                ? 'Update Social Link'
                : 'Create Social Link' }}
        </button>

        <a
            href="{{ route('admin.social-links.index') }}"
            class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
        >
            Cancel
        </a>
    </aside>
</div>
