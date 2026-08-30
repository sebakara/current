@php
    $editing = isset($section);

    $dataJson = old(
        'data_json',
        isset($section) && $section->data
            ? json_encode(
                $section->data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
            : ''
    );
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

<div class="grid gap-8 xl:grid-cols-[1fr_370px]">
    <div class="space-y-7">
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Section Information
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Section key *
                    </span>

                    <input
                        type="text"
                        name="section_key"
                        value="{{ old(
                            'section_key',
                            $section->section_key ?? ''
                        ) }}"
                        required
                        maxlength="150"
                        placeholder="hero, introduction, statistics, cta"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >

                    <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                        Use lowercase letters, numbers, underscores, or hyphens.
                        Do not change an existing key unless the frontend code
                        is also updated.
                    </span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Title
                    </span>

                    <input
                        type="text"
                        name="title"
                        value="{{ old(
                            'title',
                            $section->title ?? ''
                        ) }}"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Subtitle
                    </span>

                    <textarea
                        name="subtitle"
                        rows="4"
                        maxlength="1000"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'subtitle',
                        $section->subtitle ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Content
                    </span>

                    <textarea
                        name="content"
                        rows="14"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'content',
                        $section->content ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Structured Data
            </p>

            <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                Use this field for repeatable items such as statistics,
                benefits, buttons, cards, features, or lists.
            </p>

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    JSON data
                </span>

                <textarea
                    name="data_json"
                    rows="18"
                    spellcheck="false"
                    placeholder='{
    "button_text": "Learn More",
    "button_url": "/about",
    "items": [
        {
            "title": "Quality",
            "description": "Reliable solutions"
        }
    ]
}'
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 font-mono text-sm leading-7 text-cyan-800 dark:text-cyan-100"
                >{{ $dataJson }}</textarea>

                <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                    Leave this empty when the section does not require
                    structured data. Invalid JSON will not be saved.
                </span>
            </label>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Section Image
            </p>

            @if (
                $editing
                && $section->image
                && Storage::disk('public')->exists($section->image)
            )
                <img
                    src="{{ Storage::url($section->image) }}"
                    alt="{{ $section->title ?: $section->section_key }}"
                    class="mt-6 h-72 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
                >

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_image"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove current image
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing
                        ? 'Replace section image'
                        : 'Upload section image' }}
                </span>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>
        </section>
    </div>

    <aside>
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Display Settings
            </p>

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Layout
                </span>

                <select
                    name="layout"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
                    <option value="">Default layout</option>

                    @foreach ([
                        'full-width' => 'Full width',
                        'contained' => 'Contained',
                        'two-columns' => 'Two columns',
                        'image-left' => 'Image left',
                        'image-right' => 'Image right',
                        'cards' => 'Cards',
                        'grid' => 'Grid',
                        'statistics' => 'Statistics',
                        'testimonial' => 'Testimonial',
                        'call-to-action' => 'Call to action',
                    ] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected(
                                old(
                                    'layout',
                                    $section->layout ?? ''
                                ) === $value
                            )
                        >
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </label>

            <label class="mt-5 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                <span>
                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                        Active
                    </span>

                    <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                        Display this section on the public website.
                    </span>
                </span>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old(
                        'is_active',
                        $section->is_active ?? true
                    ))
                    class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                >
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
                        $section->sort_order ?? 0
                    ) }}"
                    min="0"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <button
                type="submit"
                class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
            >
                {{ $editing
                    ? 'Update Section'
                    : 'Create Section' }}
            </button>

            <a
                href="{{ route(
                    'admin.pages.sections.index',
                    $page
                ) }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
