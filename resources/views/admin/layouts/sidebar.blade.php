@php
    $companyName = setting('company_name', 'VTLABS');
    $shortName = setting('company_short_name', 'VT');
    $logo = setting('logo');

    $navigationGroups = [
        [
            'label' => 'Overview',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'route' => 'dashboard',
                    'active' => ['dashboard'],
                ],
            ],
        ],
        [
            'label' => 'Commerce',
            'items' => [
                [
                    'label' => 'Orders',
                    'route' => 'admin.orders.index',
                    'active' => ['admin.orders.*'],
                ],
                [
                    'label' => 'Products',
                    'route' => 'admin.products.index',
                    'active' => ['admin.products.*'],
                ],
                [
                    'label' => 'Product Categories',
                    'route' => 'admin.product-categories.index',
                    'active' => ['admin.product-categories.*'],
                ],
            ],
        ],
        [
            'label' => 'Services',
            'items' => [
                [
                    'label' => 'All Services',
                    'route' => 'admin.services.index',
                    'active' => ['admin.services.*'],
                ],
                [
                    'label' => 'Service Categories',
                    'route' => 'admin.service-categories.index',
                    'active' => ['admin.service-categories.*'],
                ],
            ],
        ],
        [
            'label' => 'Portfolio',
            'items' => [
                [
                    'label' => 'Projects',
                    'route' => 'admin.projects.index',
                    'active' => ['admin.projects.*'],
                ],
                [
                    'label' => 'Project Categories',
                    'route' => 'admin.project-categories.index',
                    'active' => ['admin.project-categories.*'],
                ],
            ],
        ],
        [
            'label' => 'Training Academy',
            'items' => [
                [
                    'label' => 'Courses',
                    'route' => 'admin.courses.index',
                    'active' => ['admin.courses.*'],
                ],
                [
                    'label' => 'Course Categories',
                    'route' => 'admin.course-categories.index',
                    'active' => ['admin.course-categories.*'],
                ],
                [
                    'label' => 'Applications',
                    'route' => 'admin.training-applications.index',
                    'active' => ['admin.training-applications.*'],
                ],
            ],
        ],
        [
            'label' => 'Enquiries',
            'items' => [
                [
                    'label' => 'Contact Messages',
                    'route' => 'admin.contact-messages.index',
                    'active' => ['admin.contact-messages.*'],
                ],
                [
                    'label' => 'Quotation Requests',
                    'route' => 'admin.quotation-requests.index',
                    'active' => ['admin.quotation-requests.*'],
                ],
            ],
        ],
        [
            'label' => 'Website Content',
            'items' => [
                [
                    'label' => 'Pages & Sections',
                    'route' => 'admin.pages.index',
                    'active' => [
                        'admin.pages.*',
                    ],
                ],
                [
                    'label' => 'Hero Slides',
                    'route' => 'admin.hero-slides.index',
                    'active' => ['admin.hero-slides.*'],
                ],
                [
                    'label' => 'Announcements',
                    'route' => 'admin.announcements.index',
                    'active' => ['admin.announcements.*'],
                ],
                [
                    'label' => 'Team Members',
                    'route' => 'admin.team-members.index',
                    'active' => ['admin.team-members.*'],
                ],
                [
                    'label' => 'Menus',
                    'route' => 'admin.menus.index',
                    'active' => ['admin.menus.*'],
                ],
                [
                    'label' => 'Footer Content',
                    'route' => 'admin.footer-sections.index',
                    'active' => [
                        'admin.footer-sections.*',
                    ],
                ],
                [
                    'label' => 'Social Links',
                    'route' => 'admin.social-links.index',
                    'active' => ['admin.social-links.*'],
                ],
            ],
        ],
        [
            'label' => 'Configuration',
            'items' => [
                [
                    'label' => 'Website Settings',
                    'route' => 'admin.settings.index',
                    'active' => ['admin.settings.*'],
                ],
                [
                    'label' => 'Profile',
                    'route' => 'profile.edit',
                    'active' => ['profile.*'],
                ],
            ],
        ],
    ];

    $isActive = function (array $patterns): bool {
        foreach ($patterns as $pattern) {
            if (request()->routeIs($pattern)) {
                return true;
            }
        }

        return false;
    };
@endphp

<aside
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-950 transition-transform duration-300 lg:translate-x-0"
    :class="{ 'translate-x-0': sidebarOpen }"
>
    <div class="flex h-20 shrink-0 items-center justify-between border-b border-slate-200 dark:border-white/10 px-5">
        <a
            href="{{ route('dashboard') }}"
            class="flex min-w-0 items-center gap-3"
        >
            @if (
                $logo
                && Storage::disk('public')->exists($logo)
            )
                <img
                    src="{{ Storage::url($logo) }}"
                    alt="{{ $companyName }}"
                    class="h-11 w-auto max-w-44 object-contain"
                >
            @else
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary shadow-lg shadow-brand-primary-dark/20">
                    <span class="text-sm font-black text-white">
                        {{ $shortName }}
                    </span>
                </div>

                <div class="min-w-0">
                    <p class="truncate text-base font-black tracking-[0.1em] text-slate-900 dark:text-white">
                        {{ $companyName }}
                    </p>

                    <p class="truncate text-[9px] font-black uppercase tracking-[0.2em] text-brand-primary">
                        Administration
                    </p>
                </div>
            @endif
        </a>

        <button
            type="button"
            class="rounded-xl border border-slate-200 dark:border-white/10 p-2 text-slate-600 dark:text-slate-400 lg:hidden"
            @click="sidebarOpen = false"
        >
            ✕
        </button>
    </div>

    <div class="admin-sidebar-scroll flex-1 overflow-y-auto px-4 py-6">
        <nav class="space-y-7">
            @foreach ($navigationGroups as $group)
                @php
                    $availableItems = collect($group['items'])
                        ->filter(
                            fn (array $item) =>
                                Route::has($item['route'])
                        );
                @endphp

                @if ($availableItems->isNotEmpty())
                    <section>
                        <p class="mb-2 px-3 text-[9px] font-black uppercase tracking-[0.22em] text-slate-600 dark:text-slate-600">
                            {{ $group['label'] }}
                        </p>

                        <div class="space-y-1">
                            @foreach ($availableItems as $item)
                                @php
                                    $active = $isActive(
                                        $item['active']
                                    );
                                @endphp

                                <a
                                    href="{{ route($item['route']) }}"
                                    @click="sidebarOpen = false"
                                    class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold transition
                                        {{ $active
                                            ? 'bg-gradient-to-r from-brand-primary/15 to-brand-secondary/10 text-brand-primary dark:text-brand-primary-light'
                                            : 'text-slate-600 dark:text-slate-500 hover:bg-slate-100 dark:hover:bg-white/[0.04] hover:text-slate-900 dark:hover:text-white'
                                        }}"
                                >
                                    <span
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl border
                                            {{ $active
                                                ? 'border-brand-primary/20 bg-brand-primary/10 text-brand-primary dark:text-brand-primary-light'
                                                : 'border-slate-200 dark:border-white/[0.06] bg-slate-50 dark:bg-white/[0.025] text-slate-600 dark:text-slate-600 group-hover:text-slate-900 dark:group-hover:text-slate-300'
                                            }}"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="1.8"
                                                d="M5 6h14M5 12h14M5 18h14"
                                            />
                                        </svg>
                                    </span>

                                    <span class="min-w-0 flex-1 truncate">
                                        {{ $item['label'] }}
                                    </span>

                                    @if ($active)
                                        <span class="h-2 w-2 rounded-full bg-brand-primary"></span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endforeach
        </nav>
    </div>

    <div class="border-t border-slate-200 dark:border-white/10 p-4">
        <a
            href="{{ url('/') }}"
            target="_blank"
            rel="noopener noreferrer"
            class="flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] px-4 py-3 text-sm font-black text-slate-600 dark:text-slate-400 transition hover:text-slate-900 dark:hover:text-white"
        >
            <span>View Website</span>
            <span>↗</span>
        </a>
    </div>
</aside>
