@php
    $companyName = setting('company_name', 'VTLABS');
    $shortName = setting('company_short_name', 'VT');
    $tagline = setting('company_tagline', 'Innovation Laboratory');
    $logo = setting('logo');

    $companyEmail = setting(
        'company_email',
        'info@vtlabs.com'
    );

    $companyPhone = setting(
        'company_phone',
        '+250 000 000 000'
    );

    $companyAddress = setting(
        'company_address',
        'Kigali, Rwanda'
    );

    $whatsAppNumber = preg_replace(
        '/\D+/',
        '',
        setting(
            'whatsapp_number',
            $companyPhone
        )
    );

    $cartCount = (int) ($cartItemCount ?? 0);

    $solutionsActive = request()->routeIs(
        'services.*',
        'manufacturing',
        'vtl-woods'
    );

    $productsActive = request()->routeIs(
        'products',
        'products.*',
        'cart.*',
        'checkout.*'
    );

    $projectsActive = request()->routeIs(
        'projects',
        'projects.*'
    );

    $academyActive = request()->routeIs(
        'academy',
        'academy.*'
    );

    $exploreActive = request()->routeIs(
        'about',
        'contact',
        'contact.*'
    );
@endphp

<header
    class="sticky top-0 z-40 border-b border-slate-200 dark:border-white/[0.06] bg-white/80 dark:bg-slate-950/80 backdrop-blur-2xl"
    x-data="{
        mobileMenuOpen: false,
        solutionsOpen: false,
        exploreOpen: false
    }"
    @keydown.escape.window="
        mobileMenuOpen = false;
        solutionsOpen = false;
        exploreOpen = false;
    "
>
    <div class="mx-auto max-w-7xl px-4 py-3 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between gap-4 rounded-[1.4rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/75 px-3 shadow-[0_18px_70px_rgba(2,6,23,0.45)] backdrop-blur-2xl sm:px-4">
            {{-- Brand --}}
            <a
                href="{{ route('home') }}"
                class="group flex min-w-0 shrink-0 items-center gap-3"
                aria-label="{{ $companyName }} homepage"
            >
                @if (
                    $logo
                    && Storage::disk('public')->exists($logo)
                )
                    <img
                        src="{{ Storage::url($logo) }}"
                        alt="{{ $companyName }}"
                        class="h-10 w-auto max-w-36 object-contain"
                    >
                @else
                    <div class="relative flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary shadow-lg shadow-brand-primary-dark/20">
                        <div class="absolute inset-0 bg-gradient-to-br from-white/20 to-transparent"></div>

                        <span class="relative text-sm font-black text-white">
                            {{ $shortName }}
                        </span>
                    </div>

                    <div class="hidden min-w-0 sm:block">
                        <p class="truncate text-base font-black tracking-[0.12em] text-slate-900 dark:text-white">
                            {{ $companyName }}
                        </p>

                        <p class="truncate text-[8px] font-black uppercase tracking-[0.22em] text-brand-primary">
                            {{ $tagline }}
                        </p>
                    </div>
                @endif
            </a>

            {{-- Desktop Navigation --}}
            <nav
                class="hidden min-w-0 items-center gap-0.5 lg:flex"
                aria-label="Primary navigation"
            >
                <a
                    href="{{ route('home') }}"
                    @if (request()->routeIs('home'))
                        aria-current="page"
                    @endif
                    class="
                        rounded-xl px-2 py-2 text-[11px] font-black transition xl:px-3 xl:text-xs
                        {{ request()->routeIs('home')
                            ? 'bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.05] hover:text-slate-900 dark:hover:text-white'
                        }}
                    "
                >
                    Home
                </a>

                {{-- Solutions Dropdown --}}
                <div
                    class="relative"
                    @mouseenter="solutionsOpen = true"
                    @mouseleave="solutionsOpen = false"
                >
                    <button
                        type="button"
                        class="
                            flex items-center gap-1.5 rounded-xl px-2 py-2
                            text-[11px] font-black transition xl:gap-2 xl:px-3 xl:text-xs
                            {{ $solutionsActive
                                ? 'bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                                : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.05] hover:text-slate-900 dark:hover:text-white'
                            }}
                        "
                        @click="
                            solutionsOpen = !solutionsOpen;
                            exploreOpen = false;
                        "
                        :aria-expanded="solutionsOpen.toString()"
                    >
                        Solutions

                        <svg
                            class="h-3.5 w-3.5 transition"
                            :class="{ 'rotate-180': solutionsOpen }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m6 9 6 6 6-6"
                            />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="solutionsOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="translate-y-2 opacity-0"
                        x-transition:enter-end="translate-y-0 opacity-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="translate-y-0 opacity-100"
                        x-transition:leave-end="translate-y-2 opacity-0"
                        class="absolute left-1/2 top-full z-50 mt-4 w-[430px] -translate-x-1/2 overflow-hidden rounded-[1.8rem] border border-slate-200 dark:border-white/10 bg-white/95 dark:bg-slate-950/95 p-3 shadow-[0_30px_90px_rgba(2,6,23,.75)] backdrop-blur-2xl"
                    >
                        <div class="grid gap-2">
                            <a
                                href="{{ route('services.index') }}"
                                class="group flex items-start gap-4 rounded-2xl border border-transparent p-4 transition hover:border-brand-primary/15 hover:bg-brand-primary/[0.06]"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M14.5 5.5a4 4 0 0 0-5 5L4 16l4 4 5.5-5.5a4 4 0 0 0 5-5l-3 3-4-4 3-3Z"
                                        />
                                    </svg>
                                </span>

                                <span class="min-w-0">
                                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                                        Services
                                    </span>

                                    <span class="mt-1 block text-xs leading-6 text-slate-600 dark:text-slate-500">
                                        Engineering, software, laboratory, electronics, and technical solutions.
                                    </span>
                                </span>
                            </a>

                            <a
                                href="{{ route('manufacturing') }}"
                                class="group flex items-start gap-4 rounded-2xl border border-transparent p-4 transition hover:border-brand-secondary-light/15 hover:bg-brand-secondary-light/[0.06]"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-brand-secondary-light/10 text-brand-secondary dark:text-brand-secondary-light">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M4 20V9l5 3V8l5 3V4h6v16H4Zm12-9h2m-2 4h2"
                                        />
                                    </svg>
                                </span>

                                <span class="min-w-0">
                                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                                        Manufacturing
                                    </span>

                                    <span class="mt-1 block text-xs leading-6 text-slate-600 dark:text-slate-500">
                                        Prototyping, digital fabrication, electronics, and small-batch production.
                                    </span>
                                </span>
                            </a>

                            <a
                                href="{{ route('vtl-woods') }}"
                                class="group flex items-start gap-4 rounded-2xl border border-transparent p-4 transition hover:border-amber-400/15 hover:bg-amber-400/[0.06]"
                            >
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-amber-400/10 text-amber-700 dark:text-amber-300">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 3v18M7 7c0-2.2 2.2-4 5-4s5 1.8 5 4-2.2 4-5 4-5-1.8-5-4Zm-2 8c0-2.2 3.1-4 7-4s7 1.8 7 4-3.1 4-7 4-7-1.8-7-4Z"
                                        />
                                    </svg>
                                </span>

                                <span class="min-w-0">
                                    <span class="block text-sm font-black text-slate-900 dark:text-white">
                                        VTL Woods
                                    </span>

                                    <span class="mt-1 block text-xs leading-6 text-slate-600 dark:text-slate-500">
                                        Custom furniture, fitted interiors, office, home, and hotel solutions.
                                    </span>
                                </span>
                            </a>
                        </div>

                        <div class="mt-3 flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-3">
                            <p class="text-xs text-slate-600 dark:text-slate-500">
                                Not sure which solution fits?
                            </p>

                            <a
                                href="{{ route('contact') }}"
                                class="text-xs font-black text-brand-primary"
                            >
                                Talk to our team →
                            </a>
                        </div>
                    </div>
                </div>

                <a
                    href="{{ route('products') }}"
                    @if ($productsActive)
                        aria-current="page"
                    @endif
                    class="
                        rounded-xl px-2 py-2 text-[11px] font-black transition xl:px-3 xl:text-xs
                        {{ $productsActive
                            ? 'bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.05] hover:text-slate-900 dark:hover:text-white'
                        }}
                    "
                >
                    Products
                </a>

                <a
                    href="{{ route('projects') }}"
                    @if ($projectsActive)
                        aria-current="page"
                    @endif
                    class="
                        rounded-xl px-2 py-2 text-[11px] font-black transition xl:px-3 xl:text-xs
                        {{ $projectsActive
                            ? 'bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.05] hover:text-slate-900 dark:hover:text-white'
                        }}
                    "
                >
                    Projects
                </a>

                <a
                    href="{{ route('academy') }}"
                    @if ($academyActive)
                        aria-current="page"
                    @endif
                    class="
                        rounded-xl px-2 py-2 text-[11px] font-black transition xl:px-3 xl:text-xs
                        {{ $academyActive
                            ? 'bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-white/[0.05] hover:text-slate-900 dark:hover:text-white'
                        }}
                    "
                >
                    Academy
                </a>

                {{-- Explore Bubble --}}
                <div class="relative">
                    <button
                        type="button"
                        class="
                            group relative flex items-center gap-2 overflow-hidden
                            rounded-full border px-3.5 py-2 text-xs font-black transition
                            {{ $exploreActive
                                ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                                : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.04] text-slate-900 dark:text-white hover:border-brand-primary/25'
                            }}
                        "
                        @click="
                            exploreOpen = !exploreOpen;
                            solutionsOpen = false;
                        "
                        :aria-expanded="exploreOpen.toString()"
                    >
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-primary opacity-40"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-primary"></span>
                        </span>

                        Explore

                        <svg
                            class="h-3.5 w-3.5 transition"
                            :class="{ 'rotate-45': exploreOpen }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 5v14M5 12h14"
                            />
                        </svg>
                    </button>

                    <div
                        x-cloak
                        x-show="exploreOpen"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="translate-y-2 scale-95 opacity-0"
                        x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                        x-transition:leave-end="translate-y-2 scale-95 opacity-0"
                        @click.outside="exploreOpen = false"
                        class="absolute right-0 top-full z-50 mt-4 w-[390px] overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white/95 dark:bg-slate-950/95 p-4 shadow-[0_30px_90px_rgba(2,6,23,.8)] backdrop-blur-2xl"
                    >
                        <div class="relative overflow-hidden rounded-[1.5rem] border border-brand-primary/10 bg-gradient-to-br from-brand-primary/[0.08] via-slate-100 dark:via-slate-900 to-brand-secondary/[0.08] p-5">
                            <div class="absolute -right-12 -top-12 h-32 w-32 rounded-full bg-brand-primary/10 blur-3xl"></div>

                            <div class="relative">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-primary">
                                    Explore VTLABS
                                </p>

                                <h3 class="mt-3 text-xl font-black text-slate-900 dark:text-white">
                                    Innovation beyond one discipline.
                                </h3>

                                <p class="mt-3 text-xs leading-6 text-slate-600 dark:text-slate-500">
                                    Discover our company, reach the team, or begin a conversation about your next project.
                                </p>
                            </div>
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-2">
                            <a
                                href="{{ route('about') }}"
                                class="rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] p-4 transition hover:border-brand-primary/15 hover:bg-brand-primary/[0.05]"
                            >
                                <span class="text-xs font-black text-slate-900 dark:text-white">
                                    About Us
                                </span>

                                <span class="mt-2 block text-[11px] leading-5 text-slate-600 dark:text-slate-500">
                                    Company, mission, team, and capabilities.
                                </span>
                            </a>

                            <a
                                href="{{ route('contact') }}"
                                class="rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] p-4 transition hover:border-brand-primary/15 hover:bg-brand-primary/[0.05]"
                            >
                                <span class="text-xs font-black text-slate-900 dark:text-white">
                                    Contact
                                </span>

                                <span class="mt-2 block text-[11px] leading-5 text-slate-600 dark:text-slate-500">
                                    Send a message or quotation request.
                                </span>
                            </a>

                            @if ($whatsAppNumber)
                                <a
                                    href="https://wa.me/{{ $whatsAppNumber }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="rounded-2xl border border-emerald-400/10 bg-emerald-400/[0.04] p-4 transition hover:bg-emerald-400/[0.08]"
                                >
                                    <span class="text-xs font-black text-emerald-700 dark:text-emerald-300">
                                        WhatsApp
                                    </span>

                                    <span class="mt-2 block text-[11px] leading-5 text-slate-600 dark:text-slate-500">
                                        Start a direct conversation with our team.
                                    </span>
                                </a>
                            @endif

                            <div class="rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] p-4">
                                <span class="text-xs font-black text-slate-900 dark:text-white">
                                    Location
                                </span>

                                <span class="mt-2 block text-[11px] leading-5 text-slate-600 dark:text-slate-500">
                                    {{ $companyAddress }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-3">
                            <p class="text-xs text-slate-600 dark:text-slate-500">
                                {{ $companyEmail }}
                            </p>

                            <p class="mt-1 text-xs font-black text-slate-900 dark:text-white">
                                {{ $companyPhone }}
                            </p>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Desktop Actions --}}
            <div class="hidden shrink-0 items-center gap-2 lg:flex">
                <x-theme-toggle />

                <a
                    href="{{ route('cart.index') }}"
                    class="
                        relative flex h-10 w-10 items-center justify-center
                        rounded-xl border transition
                        {{ request()->routeIs('cart.*', 'checkout.*')
                            ? 'border-brand-primary/30 bg-brand-primary/10 text-brand-primary-dark dark:text-brand-primary-light'
                            : 'border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] text-slate-700 dark:text-slate-300 hover:border-brand-primary/20 hover:text-brand-primary-dark dark:hover:text-brand-primary-light'
                        }}
                    "
                    aria-label="Shopping cart with {{ $cartCount }} items"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 3h2l.5 2.5M7.25 14h9.9a2 2 0 0 0 1.9-1.37L21 6H5.5M7.25 14 5.5 5.5M7.25 14l-1 2.25A1.25 1.25 0 0 0 7.4 18h10.35M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm9 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        />
                    </svg>

                    @if ($cartCount > 0)
                        <span class="absolute -right-2 -top-2 flex h-6 min-w-6 items-center justify-center rounded-full bg-brand-primary px-1.5 text-[10px] font-black text-slate-950">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>

                <a
                    href="{{ setting(
                        'header_quote_button_url',
                        route('contact') . '#quotation'
                    ) }}"
                    class="group hidden items-center gap-2 rounded-xl bg-gradient-to-r from-brand-primary to-brand-secondary px-4 py-2.5 text-sm font-black text-white shadow-lg shadow-brand-primary-dark/20 transition hover:-translate-y-0.5 xl:inline-flex"
                >
                    {{ setting(
                        'header_quote_button_text',
                        'Request a Quote'
                    ) }}

                    <span class="transition group-hover:translate-x-1">
                        →
                    </span>
                </a>
            </div>

            {{-- Mobile Controls --}}
            <div class="flex shrink-0 items-center gap-2 lg:hidden">
                <x-theme-toggle />

                <a
                    href="{{ route('cart.index') }}"
                    class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] text-slate-700 dark:text-slate-300"
                    aria-label="Shopping cart with {{ $cartCount }} items"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.8"
                            d="M3 3h2l.5 2.5M7.25 14h9.9a2 2 0 0 0 1.9-1.37L21 6H5.5M7.25 14 5.5 5.5M7.25 14l-1 2.25A1.25 1.25 0 0 0 7.4 18h10.35M9 21a1 1 0 1 0 0-2 1 1 0 0 0 0 2Zm9 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        />
                    </svg>

                    @if ($cartCount > 0)
                        <span class="absolute -right-2 -top-2 flex h-6 min-w-6 items-center justify-center rounded-full bg-brand-primary px-1.5 text-[10px] font-black text-slate-950">
                            {{ $cartCount > 99 ? '99+' : $cartCount }}
                        </span>
                    @endif
                </a>

                <button
                    type="button"
                    class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.035] text-slate-700 dark:text-slate-300"
                    @click="mobileMenuOpen = true"
                    aria-label="Open navigation menu"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Overlay --}}
    <div
        x-cloak
        x-show="mobileMenuOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 bg-white/85 dark:bg-slate-950/85 backdrop-blur-md lg:hidden"
        @click="mobileMenuOpen = false"
    ></div>

    {{-- Mobile Drawer --}}
    <aside
        x-cloak
        x-show="mobileMenuOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-[60] h-dvh w-[420px] max-w-[92vw] overflow-y-auto overscroll-contain border-l border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 p-5 shadow-2xl sm:p-6 lg:hidden"
    >
        <div class="flex items-center justify-between">
            <a
                href="{{ route('home') }}"
                class="flex items-center gap-3"
                @click="mobileMenuOpen = false"
            >
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-primary to-brand-secondary">
                    <span class="text-sm font-black text-white">
                        {{ $shortName }}
                    </span>
                </div>

                <div>
                    <p class="font-black tracking-[0.1em] text-slate-900 dark:text-white">
                        {{ $companyName }}
                    </p>

                    <p class="text-[8px] font-black uppercase tracking-[0.2em] text-brand-primary">
                        {{ $tagline }}
                    </p>
                </div>
            </a>

            <button
                type="button"
                class="flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] text-slate-600 dark:text-slate-400"
                @click="mobileMenuOpen = false"
                aria-label="Close navigation menu"
            >
                ✕
            </button>
        </div>

        <nav class="mt-8 space-y-3">
            <a
                href="{{ route('home') }}"
                class="block rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-4 text-sm font-black text-slate-900 dark:text-white"
                @click="mobileMenuOpen = false"
            >
                Home
            </a>

            <div class="rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] p-3">
                <p class="px-2 pb-2 text-[10px] font-black uppercase tracking-[0.18em] text-brand-primary">
                    Solutions
                </p>

                <div class="space-y-1">
                    <a
                        href="{{ route('services.index') }}"
                        class="block rounded-xl px-3 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.04]"
                        @click="mobileMenuOpen = false"
                    >
                        Services
                    </a>

                    <a
                        href="{{ route('manufacturing') }}"
                        class="block rounded-xl px-3 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.04]"
                        @click="mobileMenuOpen = false"
                    >
                        Manufacturing
                    </a>

                    <a
                        href="{{ route('vtl-woods') }}"
                        class="block rounded-xl px-3 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.04]"
                        @click="mobileMenuOpen = false"
                    >
                        VTL Woods
                    </a>
                </div>
            </div>

            <a
                href="{{ route('products') }}"
                class="block rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-4 text-sm font-black text-slate-900 dark:text-white"
                @click="mobileMenuOpen = false"
            >
                Products
            </a>

            <a
                href="{{ route('projects') }}"
                class="block rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-4 text-sm font-black text-slate-900 dark:text-white"
                @click="mobileMenuOpen = false"
            >
                Projects
            </a>

            <a
                href="{{ route('academy') }}"
                class="block rounded-2xl border border-slate-200 dark:border-white/[0.07] bg-white dark:bg-white/[0.025] px-4 py-4 text-sm font-black text-slate-900 dark:text-white"
                @click="mobileMenuOpen = false"
            >
                Academy
            </a>

            <div class="rounded-2xl border border-brand-primary/15 bg-brand-primary/[0.05] p-3">
                <p class="px-2 pb-2 text-[10px] font-black uppercase tracking-[0.18em] text-brand-primary">
                    Explore
                </p>

                <div class="space-y-1">
                    <a
                        href="{{ route('about') }}"
                        class="block rounded-xl px-3 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.04]"
                        @click="mobileMenuOpen = false"
                    >
                        About VTLABS
                    </a>

                    <a
                        href="{{ route('contact') }}"
                        class="block rounded-xl px-3 py-3 text-sm font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-white/[0.04]"
                        @click="mobileMenuOpen = false"
                    >
                        Contact
                    </a>

                    @if ($whatsAppNumber)
                        <a
                            href="https://wa.me/{{ $whatsAppNumber }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="block rounded-xl px-3 py-3 text-sm font-bold text-emerald-700 dark:text-emerald-300 hover:bg-emerald-400/[0.05]"
                        >
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </nav>

        <a
            href="{{ setting(
                'header_quote_button_url',
                route('contact') . '#quotation'
            ) }}"
            class="mt-6 flex w-full items-center justify-center rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-5 py-4 text-sm font-black text-white"
            @click="mobileMenuOpen = false"
        >
            Request a Quote
        </a>
    </aside>
</header>
