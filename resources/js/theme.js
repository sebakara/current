const storageKey = 'vtlabs-theme';
const validModes = ['system', 'light', 'dark'];
const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

const storedMode = () => {
    try {
        const mode = window.localStorage.getItem(storageKey);

        return validModes.includes(mode) ? mode : 'system';
    } catch {
        return 'system';
    }
};

const resolvedMode = (mode) => {
    if (mode === 'system') {
        return systemTheme.matches ? 'dark' : 'light';
    }

    return mode;
};

const applyTheme = (mode) => {
    const resolved = resolvedMode(mode);
    const isDark = resolved === 'dark';

    document.documentElement.classList.toggle('dark', isDark);
    document.documentElement.dataset.theme = resolved;
    document.documentElement.style.colorScheme = resolved;

    document
        .querySelectorAll('meta[name="theme-color"]')
        .forEach((meta) => {
            meta.content = isDark ? '#020617' : '#f8fafc';
        });

    return resolved;
};

export default function initializeTheme(Alpine) {
    Alpine.store('theme', {
        mode: storedMode(),
        dark: document.documentElement.classList.contains('dark'),

        init() {
            this.dark = applyTheme(this.mode) === 'dark';

            systemTheme.addEventListener('change', () => {
                if (this.mode === 'system') {
                    this.dark = applyTheme(this.mode) === 'dark';
                }
            });
        },

        set(mode) {
            if (!validModes.includes(mode)) {
                return;
            }

            this.mode = mode;

            try {
                window.localStorage.setItem(storageKey, mode);
            } catch {
                // The selected theme still applies for the current page.
            }

            this.dark = applyTheme(mode) === 'dark';
        },

        toggle() {
            this.set(this.dark ? 'light' : 'dark');
        },

        is(mode) {
            return this.mode === mode;
        },
    });
}
