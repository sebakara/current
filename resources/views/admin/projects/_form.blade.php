@php
    $editing = isset($project);

    $technologiesText = old(
        'technologies_text',
        collect($project->technologies ?? [])->implode(PHP_EOL)
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
                Project Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Project title *
                    </span>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $project->title ?? '') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Category *
                    </span>

                    <select
                        name="project_category_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'project_category_id',
                                        $project->project_category_id ?? ''
                                    ) == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $project->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Client name
                    </span>

                    <input
                        type="text"
                        name="client_name"
                        value="{{ old(
                            'client_name',
                            $project->client_name ?? ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Location
                    </span>

                    <input
                        type="text"
                        name="location"
                        value="{{ old(
                            'location',
                            $project->location ?? ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Completion date
                    </span>

                    <input
                        type="date"
                        name="completed_at"
                        value="{{ old(
                            'completed_at',
                            isset($project) && $project->completed_at
                                ? $project->completed_at->format('Y-m-d')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Short description
                    </span>

                    <textarea
                        name="short_description"
                        rows="4"
                        maxlength="600"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'short_description',
                        $project->short_description ?? ''
                    ) }}</textarea>
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Full description
                    </span>

                    <textarea
                        name="description"
                        rows="10"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'description',
                        $project->description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Case Study
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Challenge
                    </span>

                    <textarea
                        name="challenge"
                        rows="8"
                        placeholder="Describe the problem, limitation, or requirement."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'challenge',
                        $project->challenge ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Solution
                    </span>

                    <textarea
                        name="solution"
                        rows="8"
                        placeholder="Explain how VTLABS designed and implemented the solution."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'solution',
                        $project->solution ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Technologies and capabilities
                    </span>

                    <textarea
                        name="technologies_text"
                        rows="7"
                        placeholder="Laravel&#10;IoT sensors&#10;PCB design&#10;CNC manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $technologiesText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Enter one technology per line or separate them with commas.
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Project Media
            </p>

            @if (
                $editing
                && $project->featured_image
                && Storage::disk('public')->exists($project->featured_image)
            )
                <div class="mt-6">
                    <img
                        src="{{ Storage::url($project->featured_image) }}"
                        alt="{{ $project->title }}"
                        class="h-72 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
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
                </div>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing ? 'Replace featured image' : 'Featured image' }}
                </span>

                <input
                    type="file"
                    name="featured_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>

            @if ($editing && collect($project->gallery ?? [])->isNotEmpty())
                <div class="mt-8">
                    <p class="text-sm font-black text-slate-700 dark:text-slate-300">
                        Current gallery
                    </p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($project->gallery as $galleryImage)
                            @if (
                                $galleryImage
                                && Storage::disk('public')->exists($galleryImage)
                            )
                                <label class="overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                    <img
                                        src="{{ Storage::url($galleryImage) }}"
                                        alt="{{ $project->title }}"
                                        class="h-40 w-full object-cover"
                                    >

                                    <span class="flex items-center gap-3 p-3">
                                        <input
                                            type="checkbox"
                                            name="remove_gallery_images[]"
                                            value="{{ $galleryImage }}"
                                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                                        >

                                        <span class="text-xs font-bold text-red-700 dark:text-red-300">
                                            Remove image
                                        </span>
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <label class="mt-4 flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="remove_all_gallery_images"
                            value="1"
                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                        >

                        <span class="text-sm font-bold text-red-700 dark:text-red-300">
                            Remove all gallery images
                        </span>
                    </label>
                </div>
            @endif

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Add gallery images
                </span>

                <input
                    type="file"
                    name="gallery_images[]"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Video URL
                </span>

                <input
                    type="url"
                    name="video_url"
                    value="{{ old(
                        'video_url',
                        $project->video_url ?? ''
                    ) }}"
                    placeholder="https://youtube.com/..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
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
                            $project->meta_title ?? ''
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
                        rows="4"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'meta_description',
                        $project->meta_description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>
    </div>

    <aside class="space-y-7">
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <div class="mt-6 space-y-4">
                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Published
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Display this project publicly.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        @checked(old(
                            'is_published',
                            $project->is_published ?? true
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
@php
    $editing = isset($project);

    $technologiesText = old(
        'technologies_text',
        collect($project->technologies ?? [])->implode(PHP_EOL)
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
                Project Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Project title *
                    </span>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $project->title ?? '') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Category *
                    </span>

                    <select
                        name="project_category_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'project_category_id',
                                        $project->project_category_id ?? ''
                                    ) == $category->id
                                )
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $project->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Client name
                    </span>

                    <input
                        type="text"
                        name="client_name"
                        value="{{ old(
                            'client_name',
                            $project->client_name ?? ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Location
                    </span>

                    <input
                        type="text"
                        name="location"
                        value="{{ old(
                            'location',
                            $project->location ?? ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Completion date
                    </span>

                    <input
                        type="date"
                        name="completed_at"
                        value="{{ old(
                            'completed_at',
                            isset($project) && $project->completed_at
                                ? $project->completed_at->format('Y-m-d')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Short description
                    </span>

                    <textarea
                        name="short_description"
                        rows="4"
                        maxlength="600"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'short_description',
                        $project->short_description ?? ''
                    ) }}</textarea>
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Full description
                    </span>

                    <textarea
                        name="description"
                        rows="10"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'description',
                        $project->description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Case Study
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Challenge
                    </span>

                    <textarea
                        name="challenge"
                        rows="8"
                        placeholder="Describe the problem, limitation, or requirement."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'challenge',
                        $project->challenge ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Solution
                    </span>

                    <textarea
                        name="solution"
                        rows="8"
                        placeholder="Explain how VTLABS designed and implemented the solution."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'solution',
                        $project->solution ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Technologies and capabilities
                    </span>

                    <textarea
                        name="technologies_text"
                        rows="7"
                        placeholder="Laravel&#10;IoT sensors&#10;PCB design&#10;CNC manufacturing"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $technologiesText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Enter one technology per line or separate them with commas.
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Project Media
            </p>

            @if (
                $editing
                && $project->featured_image
                && Storage::disk('public')->exists($project->featured_image)
            )
                <div class="mt-6">
                    <img
                        src="{{ Storage::url($project->featured_image) }}"
                        alt="{{ $project->title }}"
                        class="h-72 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
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
                </div>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing ? 'Replace featured image' : 'Featured image' }}
                </span>

                <input
                    type="file"
                    name="featured_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>

            @if ($editing && collect($project->gallery ?? [])->isNotEmpty())
                <div class="mt-8">
                    <p class="text-sm font-black text-slate-700 dark:text-slate-300">
                        Current gallery
                    </p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($project->gallery as $galleryImage)
                            @if (
                                $galleryImage
                                && Storage::disk('public')->exists($galleryImage)
                            )
                                <label class="overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                    <img
                                        src="{{ Storage::url($galleryImage) }}"
                                        alt="{{ $project->title }}"
                                        class="h-40 w-full object-cover"
                                    >

                                    <span class="flex items-center gap-3 p-3">
                                        <input
                                            type="checkbox"
                                            name="remove_gallery_images[]"
                                            value="{{ $galleryImage }}"
                                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                                        >

                                        <span class="text-xs font-bold text-red-700 dark:text-red-300">
                                            Remove image
                                        </span>
                                    </span>
                                </label>
                            @endif
                        @endforeach
                    </div>

                    <label class="mt-4 flex items-center gap-3">
                        <input
                            type="checkbox"
                            name="remove_all_gallery_images"
                            value="1"
                            class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                        >

                        <span class="text-sm font-bold text-red-700 dark:text-red-300">
                            Remove all gallery images
                        </span>
                    </label>
                </div>
            @endif

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Add gallery images
                </span>

                <input
                    type="file"
                    name="gallery_images[]"
                    multiple
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >
            </label>

            <label class="mt-7 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    Video URL
                </span>

                <input
                    type="url"
                    name="video_url"
                    value="{{ old(
                        'video_url',
                        $project->video_url ?? ''
                    ) }}"
                    placeholder="https://youtube.com/..."
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
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
                            $project->meta_title ?? ''
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
                        rows="4"
                        maxlength="500"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'meta_description',
                        $project->meta_description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>
    </div>

    <aside class="space-y-7">
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <div class="mt-6 space-y-4">
                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Published
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Display this project publicly.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        @checked(old(
                            'is_published',
                            $project->is_published ?? true
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >
                </label>

                <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                    <span>
                        <span class="block text-sm font-black text-slate-900 dark:text-white">
                            Featured project
                        </span>

                        <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                            Prioritise the project on public pages.
                        </span>
                    </span>

                    <input
                        type="checkbox"
                        name="is_featured"
                        value="1"
                        @checked(old(
                            'is_featured',
                            $project->is_featured ?? false
                        ))
                        class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Sort order
                    </span>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old(
                            'sort_order',
                            $project->sort_order ?? 0
                        ) }}"
                        min="0"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>

            <button
                type="submit"
                class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-6 py-4 text-sm font-black text-white"
            >
                {{ $editing ? 'Update Project' : 'Create Project' }}
            </button>

            <a
                href="{{ route('admin.projects.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
