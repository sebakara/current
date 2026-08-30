@extends('frontend.layouts.app')

@php
    $heroSection = $sections->get('contact-hero');
    $formSection = $sections->get('contact-form');
    $quotationSection = $sections->get('contact-quotation');
    $mapSection = $sections->get('contact-map');

    $companyName = setting('company_name', 'VTLABS');
    $email = setting('contact_email', 'info@vtlabs.rw');
    $phone = setting('contact_phone', '+250 791 376 812');
    $address = setting(
        'contact_address',
        'Kigali, Rwanda'
    );

    $whatsAppNumber = preg_replace(
        '/\D+/',
        '',
        setting('whatsapp_number', '250791376812')
    );

    $whatsAppMessage = rawurlencode(
        'Hello VTLABS, I would like to discuss a project.'
    );

    $mapEmbedUrl = setting(
        'google_map_embed_url',
        ''
    );

    $serviceOptions = [
        'Engineering and Product Development',
        'Electronics and PCB Design',
        'Manufacturing and Prototyping',
        'Software Development',
        'Laboratory Setup',
        'Research and Development',
        'Technical Training',
        'VTL Woods and Furniture',
        'Industrial Automation',
        'Other',
    ];

    $budgetOptions = [
        'Not decided yet',
        'Below 500,000 RWF',
        '500,000–1,000,000 RWF',
        '1,000,000–5,000,000 RWF',
        '5,000,000–10,000,000 RWF',
        'Above 10,000,000 RWF',
    ];
@endphp

@section(
    'title',
    $page?->meta_title ?: 'Contact VTLABS'
)

@section(
    'meta_description',
    $page?->meta_description
        ?: 'Contact VTLABS or request a quotation for engineering, manufacturing, software, laboratory, training, electronics, or furniture projects.'
)

@section('content')
    <section
        class="relative min-h-[620px] overflow-hidden border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950"
        data-hero-motion
    >
        @if (
            $heroSection?->image
            && Storage::disk('public')->exists($heroSection->image)
        )
            <div class="absolute inset-0">
                <img
                    src="{{ Storage::url($heroSection->image) }}"
                    alt="{{ $heroSection->title ?: 'Contact VTLABS' }}"
                    class="h-full w-full object-cover"
                    data-motion-layer="-10"
                >

                <div class="absolute inset-0 bg-white/65 dark:bg-slate-950/65"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-white dark:from-slate-950 via-white/90 dark:via-slate-950/90 to-white/25 dark:to-slate-950/25"></div>
            </div>
        @else
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute -left-40 top-0 h-[32rem] w-[32rem] rounded-full bg-brand-primary-dark/10 blur-[140px]"
                    data-motion-layer="18"
                ></div>

                <div
                    class="absolute -right-40 bottom-0 h-[34rem] w-[34rem] rounded-full bg-brand-secondary/10 blur-[150px]"
                    data-motion-layer="-24"
                ></div>

                <div
                    class="absolute inset-0 opacity-[0.04] text-slate-900 dark:text-white"
                    style="
                        background-image:
                        linear-gradient(currentColor 1px, transparent 1px),
                        linear-gradient(90deg, currentColor 1px, transparent 1px);
                        background-size: 54px 54px;
                    "
                ></div>
            </div>
        @endif

        <div class="relative mx-auto flex min-h-[620px] max-w-7xl items-center px-4 py-24 sm:px-6 lg:px-8">
            <div class="max-w-4xl">
                <div
                    class="inline-flex items-center gap-3 rounded-full border border-brand-primary/20 bg-brand-primary/[0.08] px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-brand-primary-dark dark:text-brand-primary-light"
                    data-hero-reveal
                >
                    <span class="h-2.5 w-2.5 rounded-full bg-brand-primary"></span>

                    {{ $heroSection?->subtitle
                        ?: 'Let’s Build Something' }}
                </div>

                <h1
                    class="mt-7 text-5xl font-black leading-[0.98] tracking-[-0.045em] text-slate-900 dark:text-white sm:text-6xl lg:text-[5.2rem]"
                    data-hero-reveal
                >
                    {{ $heroSection?->title
                        ?: 'Tell us about your project or technical challenge.' }}
                </h1>

                <p
                    class="mt-7 max-w-2xl text-base leading-8 text-slate-700 dark:text-slate-300 sm:text-lg"
                    data-hero-reveal
                >
                    {{ $heroSection?->content
                        ?: 'Contact our team for engineering, manufacturing, electronics, software, laboratory, research, training, or custom furniture services.' }}
                </p>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-20">
        <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:grid-cols-2 sm:px-6 lg:grid-cols-4 lg:px-8">
            <a
                href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                class="rounded-[1.8rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6 transition hover:border-brand-primary/20"
                data-reveal="up"
            >
                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                    Phone
                </p>

                <p class="mt-4 font-black text-slate-900 dark:text-white">
                    {{ $phone }}
                </p>
            </a>

            <a
                href="mailto:{{ $email }}"
                class="rounded-[1.8rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6 transition hover:border-brand-primary/20"
                data-reveal="up"
            >
                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                    Email
                </p>

                <p class="mt-4 break-all font-black text-slate-900 dark:text-white">
                    {{ $email }}
                </p>
            </a>

            <div
                class="rounded-[1.8rem] border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] p-6"
                data-reveal="up"
            >
                <p class="text-xs font-black uppercase tracking-[0.16em] text-brand-primary">
                    Location
                </p>

                <p class="mt-4 font-black text-slate-900 dark:text-white">
                    {{ $address }}
                </p>
            </div>

            @if ($whatsAppNumber)
                <a
                    href="https://wa.me/{{ $whatsAppNumber }}?text={{ $whatsAppMessage }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="rounded-[1.8rem] border border-emerald-400/20 bg-emerald-400/[0.06] p-6 transition hover:bg-emerald-400/10"
                    data-reveal="up"
                >
                    <p class="text-xs font-black uppercase tracking-[0.16em] text-emerald-400">
                        WhatsApp
                    </p>

                    <p class="mt-4 font-black text-slate-900 dark:text-white">
                        Start a conversation
                    </p>
                </a>
            @endif
        </div>
    </section>

    <section class="border-b border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-[0.72fr_1.28fr] lg:px-8">
            <div data-reveal="left">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    {{ $formSection?->subtitle
                        ?: 'General Enquiry' }}
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $formSection?->title
                        ?: 'Send us a message.' }}
                </h2>

                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                    {{ $formSection?->content
                        ?: 'Use this form for questions, partnerships, support, training enquiries, or general communication.' }}
                </p>
            </div>

            <form
                action="{{ route('contact.message.store') }}"
                method="POST"
                class="rounded-[2rem] border border-slate-200 dark:border-white/10 bg-slate-50/90 dark:bg-slate-900/75 p-7 sm:p-9"
                data-reveal="right"
            >
                @csrf

                <input
                    type="text"
                    name="website"
                    class="hidden"
                    tabindex="-1"
                    autocomplete="off"
                >

                @if (session('contact_success'))
                    <div class="mb-7 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-4 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                        {{ session('contact_success') }}
                    </div>
                @endif

                @if ($errors->any() && old('form_type') === 'contact')
                    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <input
                    type="hidden"
                    name="form_type"
                    value="contact"
                >

                <div class="grid gap-6 sm:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Full name *
                        </span>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('form_type') === 'contact' ? old('name') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Phone number *
                        </span>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('form_type') === 'contact' ? old('phone') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Email
                        </span>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('form_type') === 'contact' ? old('email') : '' }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company
                        </span>

                        <input
                            type="text"
                            name="company"
                            value="{{ old('form_type') === 'contact' ? old('company') : '' }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Subject *
                        </span>

                        <input
                            type="text"
                            name="subject"
                            value="{{ old('form_type') === 'contact' ? old('subject') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Message *
                        </span>

                        <textarea
                            name="message"
                            rows="6"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white outline-none transition focus:border-brand-primary/40"
                        >{{ old('form_type') === 'contact' ? old('message') : '' }}</textarea>
                    </label>
                </div>

                <button
                    type="submit"
                    class="mt-7 w-full rounded-2xl bg-gradient-to-r from-brand-primary to-brand-secondary px-7 py-4 text-sm font-black text-white transition hover:-translate-y-1"
                >
                    Send Message
                </button>
            </form>
        </div>
    </section>

    <section  id="quotation" class="border-b border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-reveal="up">
                <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                    {{ $quotationSection?->subtitle
                        ?: 'Request a Quotation' }}
                </p>

                <h2 class="mt-5 text-4xl font-black tracking-[-0.035em] text-slate-900 dark:text-white sm:text-5xl">
                    {{ $quotationSection?->title
                        ?: 'Tell us what you need developed.' }}
                </h2>

                <p class="mt-5 text-sm leading-7 text-slate-600 dark:text-slate-500 sm:text-base">
                    {{ $quotationSection?->content
                        ?: 'Provide enough information for our team to understand the scope, timeline, location, and expected result.' }}
                </p>
            </div>

            <form
                action="{{ route('contact.quotation.store') }}"
                method="POST"
                class="mt-12 rounded-[2.2rem] border border-brand-primary/15 bg-gradient-to-br from-brand-primary/[0.06] via-slate-100 dark:via-slate-900 to-brand-secondary/[0.06] p-7 sm:p-10"
                data-reveal="up"
            >
                @csrf

                <input
                    type="text"
                    name="website"
                    class="hidden"
                    tabindex="-1"
                    autocomplete="off"
                >

                <input
                    type="hidden"
                    name="form_type"
                    value="quotation"
                >

                @if (session('quotation_success'))
                    <div class="mb-7 rounded-2xl border border-emerald-400/20 bg-emerald-400/10 px-5 py-5 text-sm font-semibold text-emerald-700 dark:text-emerald-300">
                        <p>
                            {{ session('quotation_success') }}
                        </p>

                        @if (session('quotation_reference'))
                            <p class="mt-2 font-black text-slate-900 dark:text-white">
                                Reference:
                                {{ session('quotation_reference') }}
                            </p>
                        @endif
                    </div>
                @endif

                @if ($errors->any() && old('form_type') === 'quotation')
                    <div class="mb-7 rounded-2xl border border-red-400/20 bg-red-400/10 px-5 py-4 text-sm text-red-700 dark:text-red-300">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="grid gap-6 sm:grid-cols-2">
                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Full name *
                        </span>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('form_type') === 'quotation' ? old('name') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Phone number *
                        </span>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('form_type') === 'quotation' ? old('phone') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Email
                        </span>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('form_type') === 'quotation' ? old('email') : '' }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Company
                        </span>

                        <input
                            type="text"
                            name="company"
                            value="{{ old('form_type') === 'quotation' ? old('company') : '' }}"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Service required *
                        </span>

                        <select
                            name="service_type"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">
                                Select a service
                            </option>

                            @foreach ($serviceOptions as $serviceOption)
                                <option
                                    value="{{ $serviceOption }}"
                                    @selected(
                                        old('form_type') === 'quotation'
                                        && old('service_type') === $serviceOption
                                    )
                                >
                                    {{ $serviceOption }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Project location
                        </span>

                        <input
                            type="text"
                            name="location"
                            value="{{ old('form_type') === 'quotation' ? old('location') : '' }}"
                            placeholder="Kigali, Rwanda"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Project title *
                        </span>

                        <input
                            type="text"
                            name="project_title"
                            value="{{ old('form_type') === 'quotation' ? old('project_title') : '' }}"
                            required
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Project description *
                        </span>

                        <textarea
                            name="project_description"
                            rows="7"
                            required
                            placeholder="Describe the problem, expected solution, quantity, measurements, features, users, or technical requirements."
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >{{ old('form_type') === 'quotation' ? old('project_description') : '' }}</textarea>
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Estimated budget
                        </span>

                        <select
                            name="budget"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">
                                Select budget range
                            </option>

                            @foreach ($budgetOptions as $budgetOption)
                                <option
                                    value="{{ $budgetOption }}"
                                    @selected(
                                        old('form_type') === 'quotation'
                                        && old('budget') === $budgetOption
                                    )
                                >
                                    {{ $budgetOption }}
                                </option>
                            @endforeach
                        </select>
                    </label>

                    <label>
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Expected timeline
                        </span>

                        <input
                            type="text"
                            name="timeline"
                            value="{{ old('form_type') === 'quotation' ? old('timeline') : '' }}"
                            placeholder="Example: Within 2 months"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                    </label>

                    <label class="sm:col-span-2">
                        <span class="mb-2 block text-sm font-black text-slate-700 dark:text-slate-300">
                            Preferred contact method
                        </span>

                        <select
                            name="preferred_contact_method"
                            class="w-full rounded-2xl border border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950 px-4 py-3.5 text-slate-900 dark:text-white"
                        >
                            <option value="">
                                Select contact method
                            </option>

                            <option
                                value="phone"
                                @selected(
                                    old('form_type') === 'quotation'
                                    && old('preferred_contact_method') === 'phone'
                                )
                            >
                                Phone call
                            </option>

                            <option
                                value="email"
                                @selected(
                                    old('form_type') === 'quotation'
                                    && old('preferred_contact_method') === 'email'
                                )
                            >
                                Email
                            </option>

                            <option
                                value="whatsapp"
                                @selected(
                                    old('form_type') === 'quotation'
                                    && old('preferred_contact_method') === 'whatsapp'
                                )
                            >
                                WhatsApp
                            </option>
                        </select>
                    </label>
                </div>

                <button
                    type="submit"
                    class="mt-8 w-full rounded-2xl bg-brand-primary px-7 py-4 text-sm font-black text-slate-950 transition hover:-translate-y-1 hover:bg-brand-primary-light"
                >
                    Submit Quotation Request
                </button>
            </form>
        </div>
    </section>

    <section class="bg-slate-50/90 dark:bg-slate-900/30 py-24">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid overflow-hidden rounded-[2.2rem] border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-slate-900 lg:grid-cols-[0.75fr_1.25fr]">
                <div class="p-8 sm:p-10">
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-brand-primary">
                        {{ $mapSection?->subtitle
                            ?: 'Visit or Contact Us' }}
                    </p>

                    <h2 class="mt-5 text-4xl font-black text-slate-900 dark:text-white">
                        {{ $mapSection?->title
                            ?: $companyName }}
                    </h2>

                    <p class="mt-5 text-base leading-8 text-slate-600 dark:text-slate-400">
                        {{ $mapSection?->content
                            ?: $address }}
                    </p>

                    <div class="mt-8 space-y-3 text-sm">
                        <p class="font-bold text-slate-700 dark:text-slate-300">
                            {{ $phone }}
                        </p>

                        <p class="font-bold text-slate-700 dark:text-slate-300">
                            {{ $email }}
                        </p>
                    </div>
                </div>

                <div class="min-h-[420px] bg-white dark:bg-slate-950">
                    @if ($mapEmbedUrl)
                        <iframe
                            src="{{ $mapEmbedUrl }}"
                            class="h-full min-h-[420px] w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    @else
                        <div class="flex min-h-[420px] items-center justify-center p-8 text-center">
                            <div>
                                <p class="text-5xl font-black text-slate-200 dark:text-white/[0.06]">
                                    MAP
                                </p>

                                <p class="mt-5 text-sm text-slate-600 dark:text-slate-500">
                                    Add the Google Maps embed URL in Website Settings.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
