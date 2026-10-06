@php
    $editing = isset($serviceCategory);
@endphp

<div class="grid gap-6 xl:grid-cols-3">
    <div class="space-y-6 xl:col-span-2">
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Category information
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                    Define how services will be grouped on the website.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2">
                    <label
                        for="name"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Category name
                        <span class="text-brand-primary">*</span>
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name', $serviceCategory->name ?? '') }}"
                        required
                        placeholder="Example: Manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none transition placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    @error('name')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="slug"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        URL slug
                    </label>

                    <input
                        id="slug"
                        name="slug"
                        type="text"
                        value="{{ old('slug', $serviceCategory->slug ?? '') }}"
                        placeholder="manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none transition placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                        Leave blank to generate it automatically.
                    </p>

                    @error('slug')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="icon"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Icon name
                    </label>

                    <input
                        id="icon"
                        name="icon"
                        type="text"
                        value="{{ old('icon', $serviceCategory->icon ?? '') }}"
                        placeholder="cpu, factory, printer..."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none transition placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    @error('icon')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="description"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="6"
                        placeholder="Briefly explain what this category contains..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none transition placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('description', $serviceCategory->description ?? '') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                Category image
            </h2>

            <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                Recommended size: 1200 × 800 pixels.
            </p>

            <div class="mt-6">
                @if ($editing && $serviceCategory->image)
                    <div class="mb-5 overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10">
                        <img
                            src="{{ Storage::url($serviceCategory->image) }}"
                            alt="{{ $serviceCategory->name }}"
                            class="h-52 w-full object-cover"
                        >
                    </div>
                @endif

                <label
                    for="image"
                    class="flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-white/[0.025] px-6 py-10 text-center transition hover:border-brand-primary/30 hover:bg-brand-primary/[0.03]"
                >
                    <svg
                        class="h-10 w-10 text-slate-600 dark:text-slate-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M4 16l4-4 4 4 3-3 5 5M4 5h16v14H4V5Zm11 4h.01"
                        />
                    </svg>

                    <span class="mt-4 text-sm font-bold text-slate-700 dark:text-slate-300">
                        Choose category image
                    </span>

                    <span class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                        JPG, PNG or WebP, maximum 5 MB
                    </span>

                    <input
                        id="image"
                        name="image"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="sr-only"
                    >
                </label>

                @error('image')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </section>
    </div>

    <div class="space-y-6">
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                Publishing
            </h2>

            <div class="mt-6 space-y-5">
                <label class="flex cursor-pointer items-start justify-between gap-5">
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            Active category
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Inactive categories remain hidden from the website.
                        </p>
                    </div>

                    <input
                        name="is_active"
                        type="hidden"
                        value="0"
                    >

                    <input
                        name="is_active"
                        type="checkbox"
                        value="1"
                        @checked(old(
                            'is_active',
                            $serviceCategory->is_active ?? true
                        ))
                        class="h-5 w-5 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/5 text-brand-primary focus:ring-brand-primary/30"
                    >
                </label>

                <div>
                    <label
                        for="sort_order"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Display order
                    </label>

                    <input
                        id="sort_order"
                        name="sort_order"
                        type="number"
                        min="0"
                        value="{{ old(
                            'sort_order',
                            $serviceCategory->sort_order ?? 0
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                        Lower numbers appear first.
                    </p>
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 to-brand-secondary/5 p-6">
            <h3 class="font-bold text-slate-900 dark:text-white">
                Save category
            </h3>

            <p class="mt-2 text-xs leading-5 text-slate-600 dark:text-slate-400">
                Review the information before saving the category.
            </p>

            <div class="mt-5 space-y-3">
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-brand-primary-dark/20 transition hover:-translate-y-0.5"
                >
                    {{ $editing ? 'Update category' : 'Create category' }}
                </button>

                <a
                    href="{{ route('admin.service-categories.index') }}"
                    class="flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-5 py-3.5 text-sm font-bold text-slate-700 dark:text-slate-300 transition hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white"
                >
                    Cancel
                </a>
            </div>
        </section>
    </div>
</div>
