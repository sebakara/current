@php
    $editing = isset($page);
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
                Page Information
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Page title *
                    </span>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $page->title ?? '') }}"
                        required
                        maxlength="200"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $page->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Existing frontend pages use slugs such as home, about,
                        services, projects, academy, and contact.
                    </span>
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
                    >{{ old('subtitle', $page->subtitle ?? '') }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Main page content
                    </span>

                    <textarea
                        name="content"
                        rows="15"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('content', $page->content ?? '') }}</textarea>

                    <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                        This is the page-level content. Individual content blocks
                        will be managed separately under Page Sections.
                    </span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Template
                    </span>

                    <select
                        name="template"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Default template</option>

                        @foreach ([
                            'home' => 'Home',
                            'about' => 'About',
                            'services' => 'Services',
                            'manufacturing' => 'Manufacturing',
                            'products' => 'Products',
                            'projects' => 'Projects',
                            'academy' => 'Academy',
                            'vtl-woods' => 'VTL Woods',
                            'contact' => 'Contact',
                            'standard' => 'Standard page',
                        ] as $value => $label)
                            <option
                                value="{{ $value }}"
                                @selected(
                                    old(
                                        'template',
                                        $page->template ?? ''
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

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Featured Image
            </p>

            @if (
                $editing
                && $page->featured_image
                && Storage::disk('public')->exists(
                    $page->featured_image
                )
            )
                <img
                    src="{{ Storage::url($page->featured_image) }}"
                    alt="{{ $page->title }}"
                    class="mt-6 h-72 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
                >

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_featured_image"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove featured image
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing
                        ? 'Replace featured image'
                        : 'Upload featured image' }}
                </span>

                <input
                    type="file"
                    name="featured_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Search Engine Optimisation
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Meta title
                    </span>

                    <input
                        type="text"
                        name="meta_title"
                        value="{{ old(
                            'meta_title',
                            $page->meta_title ?? ''
                        ) }}"
                        maxlength="255"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Meta description
                    </span>

                    <textarea
                        name="meta_description"
                        rows="5"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'meta_description',
                        $page->meta_description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>
    </div>

    <aside>
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <label class="mt-6 flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                <span>
                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                        Published
                    </span>

                    <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                        Make this page available to the frontend.
                    </span>
                </span>

                <input
                    type="checkbox"
                    name="is_published"
                    value="1"
                    @checked(old(
                        'is_published',
                        $page->is_published ?? true
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
                        $page->sort_order ?? 0
                    ) }}"
                    min="0"
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
            </label>

            <button
                type="submit"
                class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
            >
                {{ $editing ? 'Update Page' : 'Create Page' }}
            </button>

            <a
                href="{{ route('admin.pages.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
