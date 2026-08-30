@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    @php
        $statCards = [
            [
                'label' => 'Products',
                'value' => $statistics['products'],
                'description' => 'Products in the catalogue',
                'route' => 'admin.products.index',
            ],
            [
                'label' => 'Services',
                'value' => $statistics['services'],
                'description' => 'Company services',
                'route' => 'admin.services.index',
            ],
            [
                'label' => 'Projects',
                'value' => $statistics['projects'],
                'description' => 'Portfolio projects',
                'route' => 'admin.projects.index',
            ],
            [
                'label' => 'Courses',
                'value' => $statistics['courses'],
                'description' => 'Academy courses',
                'route' => 'admin.courses.index',
            ],
            [
                'label' => 'Orders',
                'value' => $statistics['orders'],
                'description' => 'Customer orders',
                'route' => 'admin.orders.index',
            ],
            [
                'label' => 'Applications',
                'value' => $statistics['applications'],
                'description' => 'Training applications',
                'route' => 'admin.training-applications.index',
            ],
            [
                'label' => 'Messages',
                'value' => $statistics['messages'],
                'description' => 'Contact enquiries',
                'route' => 'admin.contact-messages.index',
            ],
            [
                'label' => 'Quotations',
                'value' => $statistics['quotations'],
                'description' => 'Quotation requests',
                'route' => 'admin.quotation-requests.index',
            ],
        ];

        $websiteCards = [
            [
                'label' => 'Pages',
                'value' => $statistics['pages'],
                'route' => 'admin.pages.index',
            ],
            [
                'label' => 'Hero Slides',
                'value' => $statistics['hero_slides'],
                'route' => 'admin.hero-slides.index',
            ],
            [
                'label' => 'Announcements',
                'value' => $statistics['announcements'],
                'route' => 'admin.announcements.index',
            ],
            [
                'label' => 'Team Members',
                'value' => $statistics['team_members'],
                'route' => 'admin.team-members.index',
            ],
        ];

        $quickActions = [
            [
                'label' => 'Add Product',
                'route' => 'admin.products.create',
            ],
            [
                'label' => 'Add Service',
                'route' => 'admin.services.create',
            ],
            [
                'label' => 'Publish Project',
                'route' => 'admin.projects.create',
            ],
            [
                'label' => 'Create Course',
                'route' => 'admin.courses.create',
            ],
            [
                'label' => 'Add Hero Slide',
                'route' => 'admin.hero-slides.create',
            ],
            [
                'label' => 'Website Settings',
                'route' => 'admin.settings.index',
            ],
        ];
    @endphp

    <div class="space-y-7">
        <section class="relative overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-gradient-to-br from-white dark:from-slate-900 via-slate-50 dark:via-slate-900 to-cyan-50 dark:to-cyan-950/50 p-7 shadow-2xl sm:p-9">
            <div class="pointer-events-none absolute -right-24 -top-24 h-72 w-72 rounded-full bg-brand-primary/10 blur-3xl"></div>

            <div class="relative flex flex-col justify-between gap-8 lg:flex-row lg:items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-emerald-400/20 bg-emerald-400/10 px-3 py-1.5 text-xs font-black uppercase tracking-[0.16em] text-emerald-700 dark:text-emerald-300">
                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        System operational
                    </div>

                    <h1 class="mt-5 text-3xl font-black tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600 dark:text-slate-400">
                        Manage VTLABS products, services, projects, training,
                        enquiries, orders, and website content from one place.
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    @if (Route::has('admin.products.create'))
                        <a
                            href="{{ route('admin.products.create') }}"
                            class="rounded-2xl bg-brand-primary px-6 py-3.5 text-sm font-black text-slate-950 transition hover:bg-brand-primary-light"
                        >
                            Add Product
                        </a>
                    @endif

                    @if (Route::has('admin.projects.create'))
                        <a
                            href="{{ route('admin.projects.create') }}"
                            class="rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.05] px-6 py-3.5 text-sm font-black text-slate-900 dark:text-white transition hover:bg-slate-100 dark:hover:bg-white/10"
                        >
                            Add Project
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($statCards as $card)
                <a
                    href="{{ Route::has($card['route'])
                        ? route($card['route'])
                        : '#' }}"
                    class="group rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-5 transition hover:-translate-y-1 hover:border-brand-primary/20 hover:bg-slate-100 dark:hover:bg-slate-900"
                >
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-bold text-slate-600 dark:text-slate-400">
                                {{ $card['label'] }}
                            </p>

                            <p class="mt-3 text-3xl font-black text-slate-900 dark:text-white">
                                {{ number_format($card['value']) }}
                            </p>
                        </div>

                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 dark:border-white/10 bg-brand-primary/10">
                            <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>
                        </div>
                    </div>

                    <p class="mt-4 text-xs leading-5 text-slate-600 dark:text-slate-600">
                        {{ $card['description'] }}
                    </p>
                </a>
            @endforeach
        </section>

        <section class="grid gap-6 xl:grid-cols-[1fr_360px]">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-white/10 px-6 py-5">
                    <div>
                        <h2 class="font-black text-slate-900 dark:text-white">
                            Recent Training Applications
                        </h2>

                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                            Latest academy applications
                        </p>
                    </div>

                    @if (Route::has('admin.training-applications.index'))
                        <a
                            href="{{ route(
                                'admin.training-applications.index'
                            ) }}"
                            class="text-sm font-black text-brand-primary"
                        >
                            View all
                        </a>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-slate-50 dark:bg-white/[0.025]">
                            <tr class="text-left text-xs uppercase tracking-wider text-slate-600 dark:text-slate-600">
                                <th class="px-6 py-4">Applicant</th>
                                <th class="px-6 py-4">Phone</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-200 dark:divide-white/[0.06]">
                            @forelse ($recentApplications as $application)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-black text-slate-900 dark:text-white">
                                            {{ $application->full_name
                                                ?: $application->name
                                                ?: 'Applicant' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                            {{ $application->email
                                                ?: 'No email provided' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $application->phone ?: '—' }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-amber-400/10 px-3 py-1.5 text-xs font-black capitalize text-amber-700 dark:text-amber-300">
                                            {{ $application->status
                                                ?: 'pending' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $application->created_at
                                            ->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="4"
                                        class="px-6 py-14 text-center"
                                    >
                                        <p class="font-black text-slate-900 dark:text-white">
                                            No applications yet
                                        </p>

                                        <p class="mt-2 text-sm text-slate-600 dark:text-slate-600">
                                            New applications will appear here.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                <h2 class="font-black text-slate-900 dark:text-white">
                    Quick Actions
                </h2>

                <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                    Frequently used management tasks
                </p>

                <div class="mt-6 space-y-3">
                    @foreach ($quickActions as $action)
                        @if (Route::has($action['route']))
                            <a
                                href="{{ route($action['route']) }}"
                                class="group flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] px-4 py-3.5 transition hover:border-brand-primary/20 hover:bg-brand-primary/[0.05]"
                            >
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-white">
                                    {{ $action['label'] }}
                                </span>

                                <span class="text-lg text-brand-primary">
                                    →
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </aside>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-slate-900 dark:text-white">
                            Recent Contact Messages
                        </h2>

                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                            Latest website enquiries
                        </p>
                    </div>

                    @if (Route::has('admin.contact-messages.index'))
                        <a
                            href="{{ route(
                                'admin.contact-messages.index'
                            ) }}"
                            class="text-sm font-black text-brand-primary"
                        >
                            View all
                        </a>
                    @endif
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($recentMessages as $message)
                        <a
                            href="{{ Route::has(
                                'admin.contact-messages.show'
                            )
                                ? route(
                                    'admin.contact-messages.show',
                                    $message
                                )
                                : '#' }}"
                            class="block rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] p-4 transition hover:border-brand-primary/20"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $message->name }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $message->subject
                                            ?: 'General enquiry' }}
                                    </p>
                                </div>

                                <span class="rounded-full bg-brand-primary/10 px-3 py-1 text-xs font-black capitalize text-brand-primary dark:text-brand-primary-light">
                                    {{ $message->status ?: 'new' }}
                                </span>
                            </div>

                            <p class="mt-3 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-500">
                                {{ $message->message }}
                            </p>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 dark:border-white/10 px-5 py-10 text-center">
                            <p class="font-black text-slate-900 dark:text-white">
                                No contact messages yet
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-slate-900 dark:text-white">
                            Recent Quotation Requests
                        </h2>

                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                            Latest customer quotation enquiries
                        </p>
                    </div>

                    @if (Route::has('admin.quotation-requests.index'))
                        <a
                            href="{{ route(
                                'admin.quotation-requests.index'
                            ) }}"
                            class="text-sm font-black text-brand-primary"
                        >
                            View all
                        </a>
                    @endif
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($recentQuotations as $quotation)
                        <a
                            href="{{ Route::has(
                                'admin.quotation-requests.show'
                            )
                                ? route(
                                    'admin.quotation-requests.show',
                                    $quotation
                                )
                                : '#' }}"
                            class="block rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] p-4 transition hover:border-brand-primary/20"
                        >
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-black text-slate-900 dark:text-white">
                                        {{ $quotation->name
                                            ?: $quotation->full_name
                                            ?: $quotation->company_name
                                            ?: 'Customer' }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                        {{ $quotation->email
                                            ?: 'No email provided' }}
                                    </p>
                                </div>

                                <span class="rounded-full bg-purple-400/10 px-3 py-1 text-xs font-black capitalize text-purple-700 dark:text-purple-300">
                                    {{ $quotation->status ?: 'new' }}
                                </span>
                            </div>

                            <p class="mt-3 text-xs text-slate-600 dark:text-slate-600">
                                Submitted
                                {{ $quotation->created_at
                                    ->format('d M Y, H:i') }}
                            </p>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 dark:border-white/10 px-5 py-10 text-center">
                            <p class="font-black text-slate-900 dark:text-white">
                                No quotation requests yet
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1fr_360px]">
            <div class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-black text-slate-900 dark:text-white">
                            Recent Orders
                        </h2>

                        <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                            Latest catalogue purchases
                        </p>
                    </div>

                    @if (Route::has('admin.orders.index'))
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="text-sm font-black text-brand-primary"
                        >
                            View all
                        </a>
                    @endif
                </div>

                <div class="mt-6 space-y-3">
                    @forelse ($recentOrders as $order)
                        <a
                            href="{{ Route::has('admin.orders.show')
                                ? route('admin.orders.show', $order)
                                : '#' }}"
                            class="flex flex-col justify-between gap-4 rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] p-4 sm:flex-row sm:items-center"
                        >
                            <div>
                                <p class="font-black text-slate-900 dark:text-white">
                                    Order #{{ $order->id }}
                                </p>

                                <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                                    {{ $order->items_count }} items
                                    ·
                                    {{ $order->created_at
                                        ->format('d M Y') }}
                                </p>
                            </div>

                            <span class="w-fit rounded-full bg-brand-secondary-light/10 px-3 py-1.5 text-xs font-black capitalize text-brand-secondary dark:text-brand-secondary-light">
                                {{ $order->status ?: 'pending' }}
                            </span>
                        </a>
                    @empty
                        <div class="rounded-2xl border border-dashed border-slate-200 dark:border-white/10 px-5 py-10 text-center">
                            <p class="font-black text-slate-900 dark:text-white">
                                No orders yet
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-900/70 p-6">
                <h2 class="font-black text-slate-900 dark:text-white">
                    Website Content
                </h2>

                <p class="mt-1 text-xs text-slate-600 dark:text-slate-600">
                    Current CMS records
                </p>

                <div class="mt-6 space-y-3">
                    @foreach ($websiteCards as $card)
                        @if (Route::has($card['route']))
                            <a
                                href="{{ route($card['route']) }}"
                                class="flex items-center justify-between rounded-2xl border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/[0.025] px-4 py-4"
                            >
                                <span class="text-sm font-bold text-slate-600 dark:text-slate-400">
                                    {{ $card['label'] }}
                                </span>

                                <span class="text-xl font-black text-slate-900 dark:text-white">
                                    {{ number_format($card['value']) }}
                                </span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </aside>
        </section>
    </div>
@endsection
