<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="scroll-smooth"
>
<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    @php
        $defaultTitle = setting(
            'default_meta_title',
            'Innovation, Manufacturing & Technology'
        );

        $defaultDescription = setting(
            'default_meta_description',
            'Engineering, manufacturing, digital fabrication, software, and technical training solutions.'
        );

        $companyName = setting(
            'company_name',
            'VTLABS'
        );

        $favicon = setting('favicon');

        $socialImage = setting(
            'default_social_image'
        );

        $canonicalUrl = url()->current();

        $pageTitle = trim(
            $__env->yieldContent('title')
        );

        $pageDescription = trim(
            $__env->yieldContent(
                'meta_description',
                $defaultDescription
            )
        );

        $fullTitle = $pageTitle
            ? $pageTitle . ' | ' . $companyName
            : $defaultTitle . ' | ' . $companyName;

        $socialImageUrl = $socialImage
            && Storage::disk('public')->exists($socialImage)
                ? Storage::url($socialImage)
                : null;
    @endphp

    <title>{{ $fullTitle }}</title>

    <meta
        name="description"
        content="{{ $pageDescription }}"
    >

    <meta
        name="robots"
        content="@yield('robots', 'index, follow')"
    >

    <link
        rel="canonical"
        href="@yield('canonical', $canonicalUrl)"
    >

    <meta
        property="og:type"
        content="@yield('og_type', 'website')"
    >

    <meta
        property="og:site_name"
        content="{{ $companyName }}"
    >

    <meta
        property="og:title"
        content="{{ $fullTitle }}"
    >

    <meta
        property="og:description"
        content="{{ $pageDescription }}"
    >

    <meta
        property="og:url"
        content="@yield('canonical', $canonicalUrl)"
    >

    @hasSection('og_image')
        <meta
            property="og:image"
            content="@yield('og_image')"
        >
    @elseif ($socialImageUrl)
        <meta
            property="og:image"
            content="{{ $socialImageUrl }}"
        >
    @endif

    <meta
        name="twitter:card"
        content="summary_large_image"
    >

    <meta
        name="twitter:title"
        content="{{ $fullTitle }}"
    >

    <meta
        name="twitter:description"
        content="{{ $pageDescription }}"
    >

    @hasSection('og_image')
        <meta
            name="twitter:image"
            content="@yield('og_image')"
        >
    @elseif ($socialImageUrl)
        <meta
            name="twitter:image"
            content="{{ $socialImageUrl }}"
        >
    @endif

    <meta
        name="theme-color"
        content="#f8fafc"
    >

    <meta
        name="color-scheme"
        content="light dark"
    >

    <x-theme-script />

    @if (
        $favicon
        && Storage::disk('public')->exists($favicon)
    )
        <link
            rel="icon"
            href="{{ Storage::url($favicon) }}"
        >
    @endif

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
<x-brand-styles />

    @stack('styles')
</head>

<body class="bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-white">
    <div
        x-data="{
            mobileMenuOpen: false,
            flashVisible: true
        }"
        class="min-h-screen overflow-x-hidden"
        @keydown.escape.window="mobileMenuOpen = false"
    >
        <a
            href="#main-content"
            class="fixed left-4 top-4 z-[100] -translate-y-24 rounded-xl bg-brand-primary px-4 py-3 text-sm font-black text-slate-950 transition focus:translate-y-0"
        >
            Skip to content
        </a>

        @include(
            'frontend.components.announcement-bar'
        )

        @include(
            'frontend.components.header'
        )

        <div
            class="fixed inset-x-0 top-24 z-[70] mx-auto w-full max-w-3xl px-4"
            x-show="flashVisible"
            x-transition
        >
            @if (session('success'))
                <div class="frontend-alert frontend-alert-success shadow-2xl">
                    <div class="flex items-start justify-between gap-4">
                        <p>{{ session('success') }}</p>

                        <button
                            type="button"
                            class="shrink-0 text-current opacity-70 transition hover:opacity-100"
                            aria-label="Dismiss notification"
                            @click="flashVisible = false"
                        >
                            ×
                        </button>
                    </div>
                </div>
            @elseif (session('error'))
                <div class="frontend-alert frontend-alert-error shadow-2xl">
                    <div class="flex items-start justify-between gap-4">
                        <p>{{ session('error') }}</p>

                        <button
                            type="button"
                            class="shrink-0 text-current opacity-70 transition hover:opacity-100"
                            aria-label="Dismiss notification"
                            @click="flashVisible = false"
                        >
                            ×
                        </button>
                    </div>
                </div>
            @elseif (session('warning'))
                <div class="frontend-alert frontend-alert-warning shadow-2xl">
                    <div class="flex items-start justify-between gap-4">
                        <p>{{ session('warning') }}</p>

                        <button
                            type="button"
                            class="shrink-0 text-current opacity-70 transition hover:opacity-100"
                            aria-label="Dismiss notification"
                            @click="flashVisible = false"
                        >
                            ×
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <main
            id="main-content"
            tabindex="-1"
        >
            @yield('content')
        </main>

        @include(
            'frontend.components.footer'
        )
    </div>

    @stack('scripts')
</body>
</html>
