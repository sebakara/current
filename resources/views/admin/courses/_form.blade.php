@php
    $editing = isset($course);

    $modulesText = old(
        'modules_text',
        collect($course->modules ?? [])->implode(PHP_EOL)
    );

    $curriculumText = old(
        'curriculum_text',
        collect($course->curriculum ?? [])->implode(PHP_EOL)
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
                Course Information
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Course title *
                    </span>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title', $course->title ?? '') }}"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Category *
                    </span>

                    <select
                        name="course_category_id"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Select category</option>

                        @foreach ($categories as $category)
                            <option
                                value="{{ $category->id }}"
                                @selected(
                                    old(
                                        'course_category_id',
                                        $course->course_category_id ?? ''
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
                        Course code
                    </span>

                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', $course->code ?? '') }}"
                        placeholder="VTA-WEB-001"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Slug
                    </span>

                    <input
                        type="text"
                        name="slug"
                        value="{{ old('slug', $course->slug ?? '') }}"
                        placeholder="Generated automatically when empty"
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
                        $course->short_description ?? ''
                    ) }}</textarea>
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Course overview
                    </span>

                    <textarea
                        name="overview"
                        rows="9"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('overview', $course->overview ?? '') }}</textarea>
                </label>

                <label class="sm:col-span-2">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Additional description
                    </span>

                    <textarea
                        name="description"
                        rows="8"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'description',
                        $course->description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Learning Details
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Requirements
                    </span>

                    <textarea
                        name="requirements"
                        rows="7"
                        placeholder="Describe entry requirements, required devices, knowledge, or qualifications."
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'requirements',
                        $course->requirements ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Learning outcomes
                    </span>

                    <textarea
                        name="learning_outcomes"
                        rows="7"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'learning_outcomes',
                        $course->learning_outcomes ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Additional outcomes
                    </span>

                    <textarea
                        name="outcomes"
                        rows="6"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('outcomes', $course->outcomes ?? '') }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Course modules
                    </span>

                    <textarea
                        name="modules_text"
                        rows="8"
                        placeholder="Introduction and foundations&#10;Practical setup&#10;Core development skills&#10;Final project"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $modulesText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Enter one module per line.
                    </span>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Curriculum
                    </span>

                    <textarea
                        name="curriculum_text"
                        rows="9"
                        placeholder="Week 1: Fundamentals&#10;Week 2: Practical exercises&#10;Week 3: Applied project"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ $curriculumText }}</textarea>

                    <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                        Enter one curriculum item per line.
                    </span>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Course Media
            </p>

            @if (
                $editing
                && $course->featured_image
                && Storage::disk('public')->exists($course->featured_image)
            )
                <div class="mt-6">
                    <img
                        src="{{ Storage::url($course->featured_image) }}"
                        alt="{{ $course->title }}"
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

            @if ($editing && collect($course->gallery ?? [])->isNotEmpty())
                <div class="mt-8">
                    <p class="text-sm font-black text-slate-700 dark:text-slate-300">
                        Current gallery
                    </p>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($course->gallery as $galleryImage)
                            @if (
                                $galleryImage
                                && Storage::disk('public')->exists($galleryImage)
                            )
                                <label class="overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950">
                                    <img
                                        src="{{ Storage::url($galleryImage) }}"
                                        alt="{{ $course->title }}"
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
                            $course->meta_title ?? ''
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
                        $course->meta_description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>
    </div>

    <aside class="space-y-7">
        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Delivery
            </p>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Duration
                    </span>

                    <input
                        type="text"
                        name="duration"
                        value="{{ old('duration', $course->duration ?? '') }}"
                        placeholder="6 weeks"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Delivery mode
                    </span>

                    <select
                        name="delivery_mode"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        <option value="">Select mode</option>

                        @foreach ([
                            'On-site',
                            'Online',
                            'Hybrid',
                            'Self-paced',
                        ] as $mode)
                            <option
                                value="{{ $mode }}"
                                @selected(
                                    old(
                                        'delivery_mode',
                                        $course->delivery_mode ?? ''
                                    ) === $mode
                                )
                            >
                                {{ $mode }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Schedule
                    </span>

                    <textarea
                        name="schedule"
                        rows="4"
                        placeholder="Monday–Friday, 9:00 AM–1:00 PM"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old('schedule', $course->schedule ?? '') }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Location
                    </span>

                    <input
                        type="text"
                        name="location"
                        value="{{ old('location', $course->location ?? '') }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Fees
            </p>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Currency
                    </span>

                    <select
                        name="currency"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                        @foreach (['RWF', 'USD', 'EUR', 'GBP'] as $currency)
                            <option
                                value="{{ $currency }}"
                                @selected(
                                    old(
                                        'currency',
                                        $course->currency ?? 'RWF'
                                    ) === $currency
                                )
                            >
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Course fee
                    </span>

                    <input
                        type="number"
                        name="fee"
                        value="{{ old('fee', $course->fee ?? '') }}"
                        min="0"
                        step="0.01"
                        placeholder="Leave empty for price on request"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Dates & Capacity
            </p>

            <div class="mt-6 space-y-5">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Start date
                    </span>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ old(
                            'start_date',
                            isset($course) && $course->start_date
                                ? $course->start_date->format('Y-m-d')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Starts at
                    </span>

                    <input
                        type="datetime-local"
                        name="starts_at"
                        value="{{ old(
                            'starts_at',
                            isset($course) && $course->starts_at
                                ? $course->starts_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Ends at
                    </span>

                    <input
                        type="datetime-local"
                        name="ends_at"
                        value="{{ old(
                            'ends_at',
                            isset($course) && $course->ends_at
                                ? $course->ends_at->format('Y-m-d\TH:i')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Application deadline
                    </span>

                    <input
                        type="date"
                        name="application_deadline"
                        value="{{ old(
                            'application_deadline',
                            isset($course) && $course->application_deadline
                                ? $course->application_deadline->format('Y-m-d')
                                : ''
                        ) }}"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Maximum students
                    </span>

                    <input
                        type="number"
                        name="max_students"
                        value="{{ old(
                            'max_students',
                            $course->max_students ?? ''
                        ) }}"
                        min="1"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Available places
                    </span>

                    <input
                        type="number"
                        name="available_places"
                        value="{{ old(
                            'available_places',
                            $course->available_places ?? ''
                        ) }}"
                        min="0"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/80 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Publishing
            </p>

            <div class="mt-6 space-y-4">
                @foreach ([
                    'applications_open' => [
                        'Applications open',
                        'Allow students to submit applications.',
                        true,
                    ],
                    'is_published' => [
                        'Published',
                        'Display this course publicly.',
                        true,
                    ],
                    'is_featured' => [
                        'Featured course',
                        'Prioritise this course on public pages.',
                        false,
                    ],
                ] as $field => [$title, $description, $default])
                    <label class="flex items-start justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-4">
                        <span>
                            <span class="block text-sm font-black text-slate-900 dark:text-white">
                                {{ $title }}
                            </span>

                            <span class="mt-1 block text-xs leading-5 text-slate-600 dark:text-slate-600">
                                {{ $description }}
                            </span>
                        </span>

                        <input
                            type="checkbox"
                            name="{{ $field }}"
                            value="1"
                            @checked(old(
                                $field,
                                $course->{$field} ?? $default
                            ))
                            class="mt-1 rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-brand-primary"
                        >
                    </label>
                @endforeach

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Sort order
                    </span>

                    <input
                        type="number"
                        name="sort_order"
                        value="{{ old(
                            'sort_order',
                            $course->sort_order ?? 0
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
                {{ $editing ? 'Update Course' : 'Create Course' }}
            </button>

            <a
                href="{{ route('admin.courses.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
