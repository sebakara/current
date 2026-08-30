@php
    $editing = isset($service);
@endphp

<div class="grid gap-6 xl:grid-cols-3">
    <div class="space-y-6 xl:col-span-2">
        {{-- Main information --}}
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Service information
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                    Add the main information that visitors will see.
                </p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label
                        for="service_category_id"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Service category
                    </label>

                    <select
                        id="service_category_id"
                        name="service_category_id"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    (string) old(
                                        'service_category_id',
                                        $service->service_category_id ?? ''
                                    ) === (string) $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('service_category_id')
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
                        value="{{ old('icon', $service->icon ?? '') }}"
                        placeholder="Example: cpu, printer, code"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    @error('icon')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label
                        for="title"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Service title
                        <span class="text-brand-primary">*</span>
                    </label>

                    <input
                        id="title"
                        name="title"
                        type="text"
                        value="{{ old('title', $service->title ?? '') }}"
                        required
                        placeholder="Example: PCB Design and Manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    @error('title')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
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
                        value="{{ old('slug', $service->slug ?? '') }}"
                        placeholder="pcb-design-and-manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
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

                <div class="sm:col-span-2">
                    <label
                        for="short_description"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Short description
                    </label>

                    <textarea
                        id="short_description"
                        name="short_description"
                        rows="4"
                        maxlength="500"
                        placeholder="Brief service summary for cards and previews..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('short_description', $service->short_description ?? '') }}</textarea>

                    @error('short_description')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Detailed content --}}
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Detailed content
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                    Explain the service, benefits, and working process.
                </p>
            </div>

            <div class="space-y-5">
                <div>
                    <label
                        for="description"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Full description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="10"
                        placeholder="Describe this service in detail..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('description', $service->description ?? '') }}</textarea>

                    @error('description')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="benefits"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Benefits
                    </label>

                    <textarea
                        id="benefits"
                        name="benefits"
                        rows="7"
                        placeholder="List the main benefits of this service..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('benefits', $service->benefits ?? '') }}</textarea>

                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                        Put each benefit on a separate line.
                    </p>

                    @error('benefits')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="process"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Service process
                    </label>

                    <textarea
                        id="process"
                        name="process"
                        rows="7"
                        placeholder="Describe the steps followed when delivering this service..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('process', $service->process ?? '') }}</textarea>

                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                        Put each process step on a separate line.
                    </p>

                    @error('process')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Media --}}
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Service media
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                    Upload a featured image and optional gallery images.
                </p>
            </div>

            @if ($editing && $service->featured_image)
                <div class="mb-5 overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10">
                    <img
                        src="{{ Storage::url($service->featured_image) }}"
                        alt="{{ $service->title }}"
                        class="h-64 w-full object-cover"
                    >
                </div>
            @endif

            <div>
                <label
                    for="featured_image"
                    class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                >
                    Featured image
                </label>

                <label
                    for="featured_image"
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
                        Choose featured image
                    </span>

                    <span class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                        JPG, PNG or WebP, maximum 5 MB
                    </span>

                    <input
                        id="featured_image"
                        name="featured_image"
                        type="file"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="sr-only"
                    >
                </label>

                @error('featured_image')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mt-6">
                <label
                    for="gallery"
                    class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                >
                    Gallery images
                </label>

                @if ($editing && !empty($service->gallery))
                    <div class="mb-5 grid grid-cols-2 gap-3 sm:grid-cols-3">
                        @foreach ($service->gallery as $image)
                            <img
                                src="{{ Storage::url($image) }}"
                                alt="{{ $service->title }}"
                                class="h-32 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
                            >
                        @endforeach
                    </div>
                @endif

                <input
                    id="gallery"
                    name="gallery[]"
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp"
                    multiple
                    class="block w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3 text-sm text-slate-600 dark:text-slate-400 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-primary/10 file:px-4 file:py-2 file:text-sm file:font-bold file:text-brand-primary dark:file:text-brand-primary-light hover:file:bg-brand-primary/20"
                >

                <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                    Maximum 10 images. Uploading new images while editing will replace the current gallery.
                </p>

                @error('gallery')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror

                @error('gallery.*')
                    <p class="mt-2 text-sm text-red-400">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </section>

        {{-- SEO --}}
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                    Search engine optimization
                </h2>

                <p class="mt-1 text-sm text-slate-600 dark:text-slate-500">
                    Control how this service appears in search engines.
                </p>
            </div>

            <div class="space-y-5">
                <div>
                    <label
                        for="meta_title"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Meta title
                    </label>

                    <input
                        id="meta_title"
                        name="meta_title"
                        type="text"
                        value="{{ old('meta_title', $service->meta_title ?? '') }}"
                        placeholder="SEO title for this service"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    @error('meta_title')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label
                        for="meta_description"
                        class="mb-2 block text-sm font-bold text-slate-700 dark:text-slate-300"
                    >
                        Meta description
                    </label>

                    <textarea
                        id="meta_description"
                        name="meta_description"
                        rows="4"
                        maxlength="500"
                        placeholder="Short search-engine description..."
                        class="w-full resize-y rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm leading-7 text-slate-900 dark:text-white outline-none placeholder:text-slate-400 dark:placeholder:text-slate-600 focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >{{ old('meta_description', $service->meta_description ?? '') }}</textarea>

                    @error('meta_description')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>
    </div>

    {{-- Right column --}}
    <div class="space-y-6">
        <section class="rounded-3xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/60 p-6">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                Publishing
            </h2>

            <div class="mt-6 space-y-6">
                <label class="flex cursor-pointer items-start justify-between gap-5">
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            Published
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Published services can appear on the public website.
                        </p>
                    </div>

                    <input
                        type="hidden"
                        name="is_published"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        @checked(old(
                            'is_published',
                            $service->is_published ?? false
                        ))
                        class="h-5 w-5 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-white/5 text-brand-primary focus:ring-brand-primary/30"
                    >
                </label>

                <label class="flex cursor-pointer items-start justify-between gap-5">
                    <div>
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            Featured service
                        </p>

                        <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Featured services can appear on the homepage.
                        </p>
                    </div>

                    <input
                        type="hidden"
                        name="is_featured"
                        value="0"
                    >

                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        @checked(old(
                            'is_featured',
                            $service->is_featured ?? false
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
                            $service->sort_order ?? 0
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.04] px-4 py-3.5 text-sm text-slate-900 dark:text-white outline-none focus:border-brand-primary/40 focus:ring-4 focus:ring-brand-primary/10"
                    >

                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-600">
                        Lower numbers appear first.
                    </p>

                    @error('sort_order')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-brand-primary/15 bg-gradient-to-br from-brand-primary/10 to-brand-secondary/5 p-6">
            <h3 class="font-bold text-slate-900 dark:text-white">
                {{ $editing ? 'Update service' : 'Create service' }}
            </h3>

            <p class="mt-2 text-xs leading-5 text-slate-600 dark:text-slate-400">
                Review the service content before saving.
            </p>

            <div class="mt-5 space-y-3">
                <button
                    type="submit"
                    class="flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-5 py-3.5 text-sm font-black text-white shadow-lg shadow-brand-primary-dark/20 transition hover:-translate-y-0.5"
                >
                    {{ $editing ? 'Update service' : 'Create service' }}
                </button>

                <a
                    href="{{ route('admin.services.index') }}"
                    class="flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-5 py-3.5 text-sm font-bold text-slate-700 dark:text-slate-300 transition hover:bg-slate-100 dark:hover:bg-white/[0.06] hover:text-slate-900 dark:hover:text-white"
                >
                    Cancel
                </a>
            </div>
        </section>
    </div>
</div>
