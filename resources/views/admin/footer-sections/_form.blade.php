@php
    $editing = isset($footerSection);
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
            Footer Section
        </p>

        <div class="mt-6 space-y-6">
            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Section title *
                </span>

                <input
                    type="text"
                    name="title"
                    value="{{ old(
                        'title',
                        $footerSection->title ?? ''
                    ) }}"
                    required
                    maxlength="150"
                    placeholder="Company"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <label class="block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Section key *
                </span>

                <input
                    type="text"
                    name="section_key"
                    value="{{ old(
                        'section_key',
                        $footerSection->section_key ?? ''
                    ) }}"
                    required
                    maxlength="100"
                    placeholder="company"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    Use lowercase letters, numbers, underscores, or hyphens.
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
                    $footerSection->sort_order ?? 0
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

                <span class="mt-1 block text-xs text-slate-600 dark:text-slate-600">
                    Display this section in the footer.
                </span>
            </span>

            <input
                type="checkbox"
                name="is_active"
                value="1"
                @checked(old(
                    'is_active',
                    $footerSection->is_active ?? true
                ))
                class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
            >
        </label>

        <button
            type="submit"
            class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
        >
            {{ $editing
                ? 'Update Footer Section'
                : 'Create Footer Section' }}
        </button>

        <a
            href="{{ route('admin.footer-sections.index') }}"
            class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
        >
            Cancel
        </a>
    </aside>
</div>
