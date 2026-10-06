@php
    $editing = isset($productCategory);
@endphp

@if ($errors->any())
    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
        <p class="font-black text-red-700 dark:text-red-300">
            Please correct the following:
        </p>

        <ul class="mt-3 list-inside list-disc space-y-1 text-sm text-red-700 dark:text-red-200">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid gap-8 xl:grid-cols-[1fr_360px]">
    <div class="space-y-6">
        <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Category Information
            </p>

            <div class="mt-6 grid gap-6">
                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Category name *
                    </span>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $productCategory->name ?? '') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $productCategory->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Used in URLs and category filtering.
                    </span>
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Description
                    </span>

                    <textarea
                        name="description"
                        rows="7"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('description', $productCategory->description ?? '') }}</textarea>
                </label>
            </div>
        </div>

        <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Category Image
            </p>

            @if (
                $editing
                && $productCategory->image
                && Storage::disk('public')->exists($productCategory->image)
            )
                <div class="mt-6 overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10">
                    <img
                        src="{{ Storage::url($productCategory->image) }}"
                        alt="{{ $productCategory->name }}"
                        class="h-64 w-full object-cover"
                    >
                </div>

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_image"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove current image
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing ? 'Replace image' : 'Upload image' }}
                </span>

                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >

                <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                    JPG, PNG, or WebP. Maximum size: 5 MB.
                </span>
            </label>
        </div>
    </div>

    <aside class="space-y-6">
        <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <label class="mt-6 flex items-start justify-between gap-5 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                <span>
                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                        Active category
                    </span>

                    <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                        Active categories appear on the public product page.
                    </span>
                </span>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old(
                        'is_active',
                        $productCategory->is_active ?? true
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
                        $productCategory->sort_order ?? 0
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
                    ? 'Update Category'
                    : 'Create Category' }}
            </button>

            <a
                href="{{ route('admin.product-categories.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </div>
    </aside>
</div>
