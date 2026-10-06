@php
    $companyName = setting('company_name', 'VTLABS');
    $shortName = setting('company_short_name', 'VT');
    $tagline = setting('company_tagline', 'Innovation Laboratory');
    $logo = setting('logo');
    $logoExists = $logo
        && Storage::disk('public')->exists($logo);
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#f8fafc">
    <meta name="color-scheme" content="light dark">

    <title>@yield('title', 'Secure Access') | VTLABS</title>

    <meta
        name="description"
        content="Secure access to the VTLABS administration and innovation management platform."
    >

    <x-theme-script />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-brand-styles />

    @stack('styles')
</head>

<body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-white">
    <main class="relative min-h-screen overflow-hidden">
        <div class="absolute right-5 top-5 z-20 sm:right-8 sm:top-8">
            <x-theme-toggle />
        </div>

        {{-- Background effects --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -left-40 -top-40 h-[32rem] w-[32rem] rounded-full bg-brand-primary/10 blur-[120px] dark:bg-brand-primary-dark/10"></div>

            <div class="absolute -bottom-40 -right-40 h-[34rem] w-[34rem] rounded-full bg-brand-secondary/10 blur-[140px]"></div>

            <div class="absolute inset-0 opacity-[0.06] dark:hidden"
                 style="
                    background-image:
                    linear-gradient(rgba(15,23,42,.35) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(15,23,42,.35) 1px, transparent 1px);
                    background-size: 48px 48px;
                 ">
            </div>

            <div class="absolute inset-0 hidden opacity-[0.04] dark:block"
                 style="
                    background-image:
                    linear-gradient(rgba(255,255,255,.35) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(255,255,255,.35) 1px, transparent 1px);
                    background-size: 48px 48px;
                 ">
            </div>

            <div class="absolute inset-0 bg-gradient-to-br from-white/90 via-slate-50/80 to-cyan-50/50 dark:from-slate-950 dark:via-slate-950/95 dark:to-cyan-950/40"></div>
        </div>

        <div class="relative grid min-h-screen lg:grid-cols-2">
            {{-- Branding side --}}
            <section class="hidden border-r border-slate-200 dark:border-white/10 lg:flex lg:flex-col lg:justify-between lg:p-12 xl:p-16">
                <div>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-4">
                        @if ($logoExists)
                            <img
                                src="{{ Storage::url($logo) }}"
                                alt="{{ $companyName }}"
                                class="h-14 w-auto max-w-52 object-contain"
                            >
                        @else
                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary shadow-2xl shadow-brand-primary-dark/20">
                                <span class="text-xl font-black tracking-tight text-white">
                                    {{ $shortName }}
                                </span>
                            </div>

                            <div>
                                <p class="text-2xl font-black tracking-[0.12em] text-slate-900 dark:text-white">
                                    {{ $companyName }}
                                </p>

                                <p class="mt-1 text-xs font-semibold uppercase tracking-[0.26em] text-brand-primary">
                                    {{ $tagline }}
                                </p>
                            </div>
                        @endif
                    </a>
                </div>

                <div class="max-w-xl">
                    <span class="inline-flex items-center gap-2 rounded-full border border-brand-primary/30 bg-brand-primary/10 px-4 py-2 text-xs font-bold uppercase tracking-[0.18em] text-brand-primary-dark dark:border-brand-primary/20 dark:text-brand-primary-light">
                        <span class="h-2 w-2 rounded-full bg-brand-primary"></span>
                        Secure administration
                    </span>

                    <h1 class="mt-8 text-5xl font-black leading-[1.08] tracking-tight text-slate-900 dark:text-white xl:text-6xl">
                        Engineering ideas into
                        <span class="bg-gradient-to-r from-brand-primary-dark via-brand-primary to-brand-secondary-dark bg-clip-text text-transparent dark:from-brand-primary-light dark:to-brand-secondary">
                            real-world solutions.
                        </span>
                    </h1>

                    <p class="mt-6 max-w-lg text-base leading-8 text-slate-600 dark:text-slate-400">
                        Manage VTLABS services, manufacturing capabilities,
                        products, projects, training programs and customer
                        enquiries from one intelligent platform.
                    </p>

                    <div class="mt-10 grid max-w-lg grid-cols-3 gap-4">
                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 backdrop-blur dark:border-white/10 dark:bg-white/[0.04]">
                            <p class="text-xl font-black text-slate-900 dark:text-white">CMS</p>
                            <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-500">
                                Complete content control
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 backdrop-blur dark:border-white/10 dark:bg-white/[0.04]">
                            <p class="text-xl font-black text-slate-900 dark:text-white">Secure</p>
                            <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-500">
                                Protected administration
                            </p>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-white/70 p-4 backdrop-blur dark:border-white/10 dark:bg-white/[0.04]">
                            <p class="text-xl font-black text-slate-900 dark:text-white">Smart</p>
                            <p class="mt-1 text-xs leading-5 text-slate-600 dark:text-slate-500">
                                Unified operations
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-600">
                    <p>© {{ now()->year }} VTLABS. All rights reserved.</p>

                    <p>Built for innovation and growth.</p>
                </div>
            </section>

            {{-- Form side --}}
            <section class="flex min-h-screen items-center justify-center px-5 py-10 sm:px-8 lg:px-12">
                <div class="w-full max-w-md">
                    {{-- Mobile branding --}}
                    <div class="mb-10 flex items-center justify-center gap-3 lg:hidden">
                        @if ($logoExists)
                            <img
                                src="{{ Storage::url($logo) }}"
                                alt="{{ $companyName }}"
                                class="h-12 w-auto max-w-44 object-contain"
                            >
                        @else
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary shadow-xl shadow-brand-primary-dark/20">
                                <span class="font-black text-white">
                                    {{ $shortName }}
                                </span>
                            </div>

                            <div>
                                <p class="text-xl font-black tracking-[0.1em] text-slate-900 dark:text-white">
                                    {{ $companyName }}
                                </p>

                                <p class="text-[10px] font-bold uppercase tracking-[0.22em] text-brand-primary">
                                    {{ $tagline }}
                                </p>
                            </div>
                        @endif
                    </div>

                    {{ $slot }}
                </div>
            </section>
        </div>
    </main>

    @stack('scripts')
</body>
</html>
