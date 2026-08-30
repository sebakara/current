@extends('admin.layouts.app')

@section('title', 'Website Settings')

@section('content')
    @php
        $value = function (string $key, mixed $fallback = '') use ($settings) {
            return old(
                $key,
                $settings->get($key)?->value ?? $fallback
            );
        };
    @endphp

    <div class="space-y-8">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.2em] text-brand-primary">
                Global Configuration
            </p>

            <h1 class="mt-3 text-3xl font-black text-slate-900 dark:text-white sm:text-4xl">
                Website Settings
            </h1>

            <p class="mt-3 max-w-3xl text-sm leading-7 text-slate-600 dark:text-slate-500">
                Manage company identity, contact information, footer content,
                website images, and default search-engine metadata.
            </p>
        </div>

        @if (session('success'))
            <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4">
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

        <form
            method="POST"
            action="{{ route('admin.settings.update') }}"
            enctype="multipart/form-data"
            class="space-y-8"
        >
            @csrf
            @method('PUT')

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Company Identity
                </p>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company name *
                        </span>

                        <input
                            type="text"
                            name="company_name"
                            value="{{ $value('company_name', 'VTLABS') }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company short name
                        </span>

                        <input
                            type="text"
                            name="company_short_name"
                            value="{{ $value('company_short_name', 'VT') }}"
                            maxlength="20"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company tagline
                        </span>

                        <input
                            type="text"
                            name="company_tagline"
                            value="{{ $value(
                                'company_tagline',
                                'Innovation Laboratory'
                            ) }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Branding Images
                </p>

                <div class="mt-6 grid gap-7 lg:grid-cols-3">
                    @foreach ([
                        'logo' => [
                            'label' => 'Website logo',
                            'accept' => '.jpg,.jpeg,.png,.webp,.svg',
                        ],
                        'favicon' => [
                            'label' => 'Website favicon',
                            'accept' => '.ico,.png,.jpg,.jpeg,.webp',
                        ],
                        'social_share_image' => [
                            'label' => 'Social-sharing image',
                            'accept' => '.jpg,.jpeg,.png,.webp',
                        ],
                    ] as $imageKey => $imageDefinition)
                        @php
                            $imagePath = $settings
                                ->get($imageKey)?->value;
                        @endphp

                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-5">
                            <p class="font-black text-slate-900 dark:text-white">
                                {{ $imageDefinition['label'] }}
                            </p>

                            @if (
                                $imagePath
                                && Storage::disk('public')
                                    ->exists($imagePath)
                            )
                                <div class="mt-4 flex h-40 items-center justify-center overflow-hidden rounded-xl border border-slate-200 dark:border-white/10 bg-white">
                                    <img
                                        src="{{ Storage::url($imagePath) }}"
                                        alt="{{ $imageDefinition['label'] }}"
                                        class="max-h-full max-w-full object-contain"
                                    >
                                </div>

                                <label class="mt-4 flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        name="remove_{{ $imageKey }}"
                                        value="1"
                                        class="rounded border-slate-300 dark:border-white/20 bg-slate-50 dark:bg-slate-950 text-red-400"
                                    >

                                    <span class="text-xs font-bold text-red-700 dark:text-red-300">
                                        Remove current image
                                    </span>
                                </label>
                            @endif

                            <input
                                type="file"
                                name="{{ $imageKey }}"
                                accept="{{ $imageDefinition['accept'] }}"
                                class="mt-4 block w-full rounded-xl border border-dashed border-slate-200 dark:border-white/15 bg-white dark:bg-slate-900 px-3 py-3 text-xs text-slate-600 dark:text-slate-400"
                            >
                        </div>
                    @endforeach
                </div>
            </section>

            <section
                x-data="{
                    primary: '{{ $value('brand_primary', '#22D3EE') }}',
                    primaryLight: '{{ $value('brand_primary_light', '#67E8F9') }}',
                    primaryDark: '{{ $value('brand_primary_dark', '#0891B2') }}',
                    secondary: '{{ $value('brand_secondary', '#2563EB') }}',
                    secondaryLight: '{{ $value('brand_secondary_light', '#60A5FA') }}',
                    secondaryDark: '{{ $value('brand_secondary_dark', '#1D4ED8') }}',
                    accent: '{{ $value('brand_accent', '#10B981') }}'
                }"
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7"
            >
                <div class="flex flex-col justify-between gap-5 lg:flex-row lg:items-start">
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                            Brand Colors
                        </p>

                        <h2 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                            Website Color System
                        </h2>

                        <p class="mt-2 max-w-2xl text-sm leading-7 text-slate-600 dark:text-slate-500">
                            These colors control branded buttons, links,
                            navigation highlights, gradients, borders,
                            and decorative elements across the public website
                            and administration dashboard.
                        </p>
                    </div>

                    <button
                        type="button"
                        @click="
                            primary = '#22D3EE';
                            primaryLight = '#67E8F9';
                            primaryDark = '#0891B2';
                            secondary = '#2563EB';
                            secondaryLight = '#60A5FA';
                            secondaryDark = '#1D4ED8';
                            accent = '#10B981';
                        "
                        class="w-fit rounded-xl border border-slate-200 dark:border-white/10 px-4 py-2.5 text-xs font-black text-slate-600 dark:text-slate-400 transition hover:border-brand-primary/30 hover:text-slate-900 dark:hover:text-white"
                    >
                        Restore defaults
                    </button>
                </div>

                <div class="mt-7 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ([
                        [
                            'name' => 'brand_primary',
                            'model' => 'primary',
                            'label' => 'Primary',
                            'description' => 'Main buttons, links, and highlights',
                        ],
                        [
                            'name' => 'brand_primary_light',
                            'model' => 'primaryLight',
                            'label' => 'Primary Light',
                            'description' => 'Hover states and bright brand text',
                        ],
                        [
                            'name' => 'brand_primary_dark',
                            'model' => 'primaryDark',
                            'label' => 'Primary Dark',
                            'description' => 'Dark accents and supporting backgrounds',
                        ],
                        [
                            'name' => 'brand_secondary',
                            'model' => 'secondary',
                            'label' => 'Secondary',
                            'description' => 'Gradients and supporting actions',
                        ],
                        [
                            'name' => 'brand_secondary_light',
                            'model' => 'secondaryLight',
                            'label' => 'Secondary Light',
                            'description' => 'Bright secondary hover states',
                        ],
                        [
                            'name' => 'brand_secondary_dark',
                            'model' => 'secondaryDark',
                            'label' => 'Secondary Dark',
                            'description' => 'Deep secondary accents',
                        ],
                        [
                            'name' => 'brand_accent',
                            'model' => 'accent',
                            'label' => 'Accent',
                            'description' => 'Special branded details',
                        ],
                    ] as $color)
                        <div class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-5">
                            <div class="flex items-start gap-4">
                                <input
                                    type="color"
                                    x-model="{{ $color['model'] }}"
                                    aria-label="{{ $color['label'] }} color picker"
                                    class="h-14 w-14 shrink-0 cursor-pointer rounded-xl border border-slate-200 dark:border-white/10 bg-transparent p-1"
                                >

                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-black text-slate-900 dark:text-white">
                                        {{ $color['label'] }}
                                    </p>

                                    <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-600">
                                        {{ $color['description'] }}
                                    </p>
                                </div>
                            </div>

                            <input
                                type="text"
                                name="{{ $color['name'] }}"
                                x-model="{{ $color['model'] }}"
                                required
                                pattern="^#[0-9A-Fa-f]{6}$"
                                maxlength="7"
                                spellcheck="false"
                                class="mt-4 w-full rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900 px-4 py-3 font-mono text-sm uppercase text-slate-900 dark:text-white"
                            >
                        </div>
                    @endforeach
                </div>

                <div class="mt-7 overflow-hidden rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 p-6">
                    <p class="text-xs font-black uppercase tracking-[0.18em] text-slate-600 dark:text-slate-600">
                        Live Preview
                    </p>

                    <div class="mt-5 flex flex-wrap gap-3">
                        <div
                            class="rounded-xl px-5 py-3 text-sm font-black text-slate-950"
                            :style="`background-color: ${primary}`"
                        >
                            Primary Button
                        </div>

                        <div
                            class="rounded-xl px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
                            :style="`
                                background: linear-gradient(
                                    90deg,
                                    ${primary},
                                    ${secondary}
                                )
                            `"
                        >
                            Brand Gradient
                        </div>

                        <div
                            class="rounded-xl border px-5 py-3 text-sm font-black"
                            :style="`
                                color: ${primary};
                                border-color: ${primary}55;
                                background-color: ${primary}15;
                            `"
                        >
                            Highlight
                        </div>

                        <div
                            class="rounded-xl px-5 py-3 text-sm font-black text-slate-900 dark:text-white"
                            :style="`background-color: ${accent}`"
                        >
                            Accent
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Primary Contact Information
                </p>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company email *
                        </span>

                        <input
                            type="email"
                            name="company_email"
                            value="{{ $value(
                                'company_email',
                                'info@vtlabs.com'
                            ) }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company phone *
                        </span>

                        <input
                            type="text"
                            name="company_phone"
                            value="{{ $value('company_phone') }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company address *
                        </span>

                        <textarea
                            name="company_address"
                            rows="3"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value(
                            'company_address',
                            'Kigali, Rwanda'
                        ) }}</textarea>
                    </label>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Contact Page
                </p>

                <p class="mt-3 text-sm leading-7 text-slate-600 dark:text-slate-500">
                    Leave the contact-page fields empty to continue using
                    the fallback values currently defined by the frontend.
                </p>

                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Contact-page email
                        </span>

                        <input
                            type="email"
                            name="contact_email"
                            value="{{ $value('contact_email') }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Contact-page phone
                        </span>

                        <input
                            type="text"
                            name="contact_phone"
                            value="{{ $value('contact_phone') }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            WhatsApp number
                        </span>

                        <input
                            type="text"
                            name="whatsapp_number"
                            value="{{ $value('whatsapp_number') }}"
                            placeholder="250791376812"
                            inputmode="numeric"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >

                        <span class="mt-2 block text-xs text-slate-600 dark:text-slate-600">
                            Enter digits only, including the country code.
                        </span>
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Operating hours
                        </span>

                        <textarea
                            name="operating_hours"
                            rows="3"
                            placeholder="Monday–Friday: 8:00 AM–5:00 PM"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value('operating_hours') }}</textarea>
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Contact-page address
                        </span>

                        <textarea
                            name="contact_address"
                            rows="3"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value('contact_address') }}</textarea>
                    </label>

                    <label class="md:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Google Maps embed URL
                        </span>

                        <textarea
                            name="map_embed_url"
                            rows="4"
                            placeholder="https://www.google.com/maps/embed?pb=..."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value('map_embed_url') }}</textarea>
                    </label>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Footer
                </p>

                <div class="mt-6 space-y-6">
                    <label class="block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Footer description
                        </span>

                        <textarea
                            name="footer_description"
                            rows="5"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value('footer_description') }}</textarea>
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Copyright text
                        </span>

                        <input
                            type="text"
                            name="copyright_text"
                            value="{{ $value(
                                'copyright_text',
                                'All rights reserved.'
                            ) }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <div class="grid gap-6 md:grid-cols-2">
                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Privacy-policy URL
                            </span>

                            <input
                                type="text"
                                name="privacy_policy_url"
                                value="{{ $value(
                                    'privacy_policy_url'
                                ) }}"
                                placeholder="/privacy-policy"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>

                        <label>
                            <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                                Terms-and-conditions URL
                            </span>

                            <input
                                type="text"
                                name="terms_url"
                                value="{{ $value('terms_url') }}"
                                placeholder="/terms"
                                class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                            >
                        </label>
                    </div>
                </div>
            </section>

            <section class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-7">
                <p class="text-xs font-black uppercase tracking-[0.18em] text-brand-primary">
                    Default SEO
                </p>

                <div class="mt-6 space-y-6">
                    <label class="block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Default meta title
                        </span>

                        <input
                            type="text"
                            name="default_meta_title"
                            value="{{ $value(
                                'default_meta_title'
                            ) }}"
                            maxlength="255"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="block">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Default meta description
                        </span>

                        <textarea
                            name="default_meta_description"
                            rows="5"
                            maxlength="500"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ $value(
                            'default_meta_description'
                        ) }}</textarea>
                    </label>
                </div>
            </section>

            <div class="sticky bottom-5 flex justify-end">
                <button
                    type="submit"
                    class="rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-8 py-4 text-sm font-black text-white shadow-2xl"
                >
                    Save Website Settings
                </button>
            </div>
        </form>
    </div>
@endsection
