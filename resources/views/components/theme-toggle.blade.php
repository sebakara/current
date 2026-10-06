<button
    type="button"
    x-data
    class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white/80 text-slate-600 shadow-sm backdrop-blur transition hover:border-brand-primary/30 hover:text-brand-primary-dark dark:border-white/10 dark:bg-white/[0.045] dark:text-slate-300 dark:hover:text-brand-primary-light"
    :aria-label="$store.theme.dark ? 'Switch to light mode' : 'Switch to dark mode'"
    :title="$store.theme.dark ? 'Switch to light mode' : 'Switch to dark mode'"
    @click="$store.theme.toggle()"
>
    <svg
        x-show="!$store.theme.dark"
        class="h-5 w-5"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        aria-hidden="true"
    >
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.35 15.35A9 9 0 0 1 8.65 3.65a9 9 0 1 0 11.7 11.7Z" />
    </svg>

    <svg
        x-show="$store.theme.dark"
        x-cloak
        class="h-5 w-5"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        aria-hidden="true"
    >
        <circle cx="12" cy="12" r="4" stroke-width="2" />
        <path stroke-linecap="round" stroke-width="2" d="M12 2v2m0 16v2M4.93 4.93l1.42 1.42m11.3 11.3 1.42 1.42M2 12h2m16 0h2M4.93 19.07l1.42-1.42m11.3-11.3 1.42-1.42" />
    </svg>
</button>
