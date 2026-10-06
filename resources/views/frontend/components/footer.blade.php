@php
    $companyName = setting('company_name', 'VTLABS');
    $shortName = setting('company_short_name', 'VT');
    $tagline = setting('company_tagline', 'Innovation Laboratory');
    $logo = setting('logo');

    $footerDescription = setting(
        'footer_description',
        'Engineering, manufacturing, technology, and practical training solutions.'
    );

    $companyAddress = setting(
        'company_address',
        'Kigali, Rwanda'
    );

    $companyEmail = setting(
        'company_email',
        'info@vtlabs.com'
    );

    $companyPhone = setting(
        'company_phone',
        '+250 000 000 000'
    );

    $whatsAppNumber = preg_replace(
        '/\D+/',
        '',
        setting(
            'whatsapp_number',
            $companyPhone
        )
    );

    $copyrightText = setting(
        'copyright_text',
        'All rights reserved.'
    );

    $fallbackFooterSections = collect([
        [
            'title' => 'Company',
            'links' => collect([
                [
                    'label' => 'About Us',
                    'url' => route('about'),
                    'target' => '_self',
                ],
                [
                    'label' => 'Our Services',
                    'url' => route('services.index'),
                    'target' => '_self',
                ],
                [
                    'label' => 'Projects',
                    'url' => route('projects'),
                    'target' => '_self',
                ],
                [
                    'label' => 'Contact',
                    'url' => route('contact'),
                    'target' => '_self',
                ],
            ]),
        ],
        [
            'title' => 'Solutions',
            'links' => collect([
                [
                    'label' => 'Manufacturing',
                    'url' => route('manufacturing'),
                    'target' => '_self',
                ],
                [
                    'label' => 'Products',
                    'url' => route('products'),
                    'target' => '_self',
                ],
                [
                    'label' => 'Training Academy',
                    'url' => route('academy'),
                    'target' => '_self',
                ],
                [
                    'label' => 'VTL Woods',
                    'url' => route('vtl-woods'),
                    'target' => '_self',
                ],
            ]),
        ],
    ]);

    $displayFooterSections = $footerSections->isNotEmpty()
        ? $footerSections
        : $fallbackFooterSections;
@endphp

<footer class="border-t border-slate-200 dark:border-white/10 bg-white dark:bg-slate-950">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 sm:grid-cols-2 lg:grid-cols-5">
            <div class="sm:col-span-2 lg:col-span-2">
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center gap-3"
                >
                    @if ($logo && Storage::disk('public')->exists($logo))
                        <img
                            src="{{ Storage::url($logo) }}"
                            alt="{{ $companyName }}"
                            class="h-12 w-auto max-w-44 object-contain"
                        >
                    @else
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-brand-primary to-brand-secondary">
                            <span class="font-black text-white">
                                {{ $shortName }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xl font-black tracking-[0.12em] text-slate-900 dark:text-white">
                                {{ $companyName }}
                            </p>

                            <p class="text-[10px] font-bold uppercase tracking-[0.24em] text-brand-primary">
                                {{ $tagline }}
                            </p>
                        </div>
                    @endif
                </a>

                <p class="mt-5 max-w-md text-sm leading-7 text-slate-600 dark:text-slate-500">
                    {{ $footerDescription }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($socialLinks->isNotEmpty())
                        @foreach ($socialLinks as $social)
                            @if ($social->url && $social->url !== '#')
                                <a
                                    href="{{ $social->url }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="rounded-xl border border-slate-200 dark:border-white/10 bg-white dark:bg-white/[0.03] px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-400 transition hover:border-brand-primary/20 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                                >
                                    {{ $social->platform }}
                                </a>
                            @endif
                        @endforeach
                    @endif

                    @if ($whatsAppNumber)
                        <a
                            href="https://wa.me/{{ $whatsAppNumber }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="rounded-xl border border-emerald-400/15 bg-emerald-400/[0.06] px-4 py-2 text-xs font-bold text-emerald-700 dark:text-emerald-300 transition hover:bg-emerald-400/10"
                        >
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>

            @foreach ($displayFooterSections as $section)
                @php
                    $sectionTitle = is_array($section)
                        ? ($section['title'] ?? 'Explore')
                        : $section->title;

                    $links = is_array($section)
                        ? collect($section['links'] ?? [])
                        : $section->links;
                @endphp

                @if ($links->isNotEmpty())
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-[0.18em] text-slate-900 dark:text-white">
                            {{ $sectionTitle }}
                        </h3>

                        <div class="mt-5 space-y-3">
                            @foreach ($links as $link)
                                @php
                                    $label = is_array($link)
                                        ? ($link['label'] ?? 'Link')
                                        : $link->label;

                                    $url = is_array($link)
                                        ? ($link['url'] ?? '#')
                                        : $link->resolved_url;

                                    $target = is_array($link)
                                        ? ($link['target'] ?? '_self')
                                        : ($link->target ?: '_self');
                                @endphp

                                <a
                                    href="{{ $url }}"
                                    target="{{ $target }}"
                                    @if ($target === '_blank')
                                        rel="noopener noreferrer"
                                    @endif
                                    class="block text-sm text-slate-600 dark:text-slate-500 transition hover:translate-x-1 hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                                >
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <div>
                <h3 class="text-sm font-black uppercase tracking-[0.18em] text-slate-900 dark:text-white">
                    {{ setting(
                        'footer_contact_title',
                        'Contact'
                    ) }}
                </h3>

                <div class="mt-5 space-y-4 text-sm text-slate-600 dark:text-slate-500">
                    @if ($companyAddress)
                        <p class="leading-7">
                            {{ $companyAddress }}
                        </p>
                    @endif

                    @if ($companyEmail)
                        <a
                            href="mailto:{{ $companyEmail }}"
                            class="block break-all transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                        >
                            {{ $companyEmail }}
                        </a>
                    @endif

                    @if ($companyPhone)
                        <a
                            href="tel:{{ preg_replace('/\s+/', '', $companyPhone) }}"
                            class="block transition hover:text-brand-primary-dark dark:hover:text-brand-primary-light"
                        >
                            {{ $companyPhone }}
                        </a>
                    @endif

                    <a
                        href="{{ route('contact') }}"
                        class="inline-flex rounded-xl bg-brand-primary/10 px-4 py-2.5 font-bold text-brand-primary-dark dark:text-brand-primary-light transition hover:bg-brand-primary/20"
                    >
                        {{ setting(
                            'footer_contact_button_text',
                            'Contact Us'
                        ) }}
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-12 flex flex-col justify-between gap-5 border-t border-slate-200 dark:border-white/10 pt-6 text-xs text-slate-500 dark:text-slate-600 sm:flex-row sm:items-center">
            <p>
                © {{ now()->year }} {{ $companyName }}.
                {{ $copyrightText }}
            </p>

            <div class="flex flex-wrap gap-5">
                @if (setting('privacy_policy_url'))
                    <a
                        href="{{ setting('privacy_policy_url') }}"
                        class="transition hover:text-slate-600 dark:hover:text-slate-400"
                    >
                        {{ setting(
                            'privacy_policy_label',
                            'Privacy Policy'
                        ) }}
                    </a>
                @endif

                @if (setting('terms_url'))
                    <a
                        href="{{ setting('terms_url') }}"
                        class="transition hover:text-slate-600 dark:hover:text-slate-400"
                    >
                        {{ setting(
                            'terms_label',
                            'Terms of Use'
                        ) }}
                    </a>
                @endif

                <a
                    href="#"
                    class="transition hover:text-slate-600 dark:hover:text-slate-400"
                    onclick="window.scrollTo({ top: 0, behavior: 'smooth' }); return false;"
                >
                    Back to top ↑
                </a>
            </div>
        </div>
    </div>
</footer>
