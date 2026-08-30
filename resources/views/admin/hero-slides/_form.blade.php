@php
    $editing = isset($heroSlide);
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
                Slide Content
            </p>

            <div class="mt-6 space-y-6">
                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Eyebrow text
                    </span>

                    <input
                        type="text"
                        name="eyebrow"
                        value="{{ old(
                            'eyebrow',
                            $heroSlide->eyebrow ?? ''
                        ) }}"
                        maxlength="150"
                        placeholder="Technology • Manufacturing • Training"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Main title *
                    </span>

                    <textarea
                        name="title"
                        rows="4"
                        maxlength="500"
                        required
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'title',
                        $heroSlide->title ?? ''
                    ) }}</textarea>
                </label>

                <label class="block">
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Description
                    </span>

                    <textarea
                        name="description"
                        rows="6"
                        maxlength="3000"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >{{ old(
                        'description',
                        $heroSlide->description ?? ''
                    ) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Call-to-Action Buttons
            </p>

            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Primary button text
                    </span>

                    <input
                        type="text"
                        name="primary_button_text"
                        value="{{ old(
                            'primary_button_text',
                            $heroSlide->primary_button_text ?? ''
                        ) }}"
                        maxlength="100"
                        placeholder="Explore Services"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Primary button URL
                    </span>

                    <input
                        type="text"
                        name="primary_button_url"
                        value="{{ old(
                            'primary_button_url',
                            $heroSlide->primary_button_url ?? ''
                        ) }}"
                        maxlength="500"
                        placeholder="/services"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Secondary button text
                    </span>

                    <input
                        type="text"
                        name="secondary_button_text"
                        value="{{ old(
                            'secondary_button_text',
                            $heroSlide->secondary_button_text ?? ''
                        ) }}"
                        maxlength="100"
                        placeholder="Contact Us"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>

                <label>
                    <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                        Secondary button URL
                    </span>

                    <input
                        type="text"
                        name="secondary_button_url"
                        value="{{ old(
                            'secondary_button_url',
                            $heroSlide->secondary_button_url ?? ''
                        ) }}"
                        maxlength="500"
                        placeholder="/contact"
                        class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                    >
                </label>
            </div>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Desktop Background Image
            </p>

            @if (
                $editing
                && $heroSlide->background_image
                && Storage::disk('public')->exists(
                    $heroSlide->background_image
                )
            )
                <img
                    src="{{ Storage::url(
                        $heroSlide->background_image
                    ) }}"
                    alt="{{ $heroSlide->title }}"
                    class="mt-6 h-80 w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover"
                >

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_background_image"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove desktop image
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing
                        ? 'Replace desktop image'
                        : 'Upload desktop image' }}
                </span>

                <input
                    type="file"
                    name="background_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >

                <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                    Recommended size: 1920 × 1080 pixels or wider.
                </span>
            </label>
        </section>

        <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
            <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                Mobile Background Image
            </p>

            @if (
                $editing
                && $heroSlide->mobile_image
                && Storage::disk('public')->exists(
                    $heroSlide->mobile_image
                )
            )
                <img
                    src="{{ Storage::url(
                        $heroSlide->mobile_image
                    ) }}"
                    alt="{{ $heroSlide->title }}"
                    class="mt-6 h-[440px] w-full rounded-2xl border border-slate-200 dark:border-white/10 object-cover sm:w-72"
                >

                <label class="mt-4 flex items-center gap-3">
                    <input
                        type="checkbox"
                        name="remove_mobile_image"
                        value="1"
                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                    >

                    <span class="text-sm font-bold text-red-700 dark:text-red-300">
                        Remove mobile image
                    </span>
                </label>
            @endif

            <label class="mt-6 block">
                <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                    {{ $editing
                        ? 'Replace mobile image'
                        : 'Upload mobile image' }}
                </span>

                <input
                    type="file"
                    name="mobile_image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="block w-full rounded-2xl border border-dashed border-slate-200 dark:border-white/15 bg-slate-50 dark:bg-slate-950 px-4 py-4 text-sm text-slate-600 dark:text-slate-400"
                >

                <span class="mt-2 block text-xs leading-6 text-slate-600 dark:text-slate-600">
                    Recommended size: 1080 × 1350 or 1080 × 1920 pixels.
                </span>
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
                    Text position
                </span>

                <select
                    name="text_position"
                    required
                    class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                >
                    @foreach ([
                        'left' => 'Left',
                        'center' => 'Center',
                        'right' => 'Right',
                    ] as $value => $label)
                        <option
                            value="{{ $value }}"
                            @selected(
                                old(
                                    'text_position',
                                    $heroSlide->text_position ?? 'left'
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
                        Display this slide on the public homepage.
                    </span>
                </span>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    @checked(old(
                        'is_active',
                        $heroSlide->is_active ?? true
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
                        $heroSlide->sort_order ?? 0
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
                    ? 'Update Hero Slide'
                    : 'Create Hero Slide' }}
            </button>

            <a
                href="{{ route('admin.hero-slides.index') }}"
                class="mt-3 flex w-full items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.03] px-6 py-4 text-sm font-black text-slate-600 dark:text-slate-400"
            >
                Cancel
            </a>
        </section>
    </aside>
</div>
