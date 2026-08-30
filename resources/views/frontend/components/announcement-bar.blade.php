@if ($announcement)
    @php
        $announcementText = $announcement->message
            ?: $announcement->title
            ?: null;

        $announcementButtonText =
            $announcement->button_text;

        $announcementButtonUrl =
            $announcement->button_url ?: '#';
    @endphp

    @if ($announcementText)
        <div
            x-data="{ announcementVisible: true }"
            x-show="announcementVisible"
            x-transition
            class="relative z-50 border-b border-brand-primary/10 bg-brand-primary text-slate-950"
            role="status"
        >
            <div class="mx-auto flex min-h-10 max-w-7xl items-center justify-center gap-3 px-10 py-2.5 text-center sm:px-12 lg:px-14">
                <span class="hidden h-2 w-2 shrink-0 rounded-full bg-white dark:bg-slate-950 sm:block"></span>

                <p class="text-[11px] font-black uppercase leading-5 tracking-[0.1em] sm:text-sm">
                    {{ $announcementText }}
                </p>

                @if ($announcementButtonText)
                    <a
                        href="{{ $announcementButtonUrl }}"
                        class="hidden shrink-0 rounded-full bg-white dark:bg-slate-950 px-3 py-1 text-[10px] font-black uppercase tracking-wider text-slate-900 dark:text-white transition hover:bg-slate-800 sm:inline-flex"
                    >
                        {{ $announcementButtonText }}
                    </a>
                @endif
            </div>

            <button
                type="button"
                class="absolute right-3 top-1/2 flex h-7 w-7 -translate-y-1/2 items-center justify-center rounded-full text-slate-950/60 transition hover:bg-slate-100 dark:hover:bg-slate-950/10 hover:text-slate-950"
                aria-label="Dismiss announcement"
                @click="announcementVisible = false"
            >
                ×
            </button>
        </div>
    @endif
@endif
