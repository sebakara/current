<script>
    (() => {
        const storageKey = 'vtlabs-theme';
        const validModes = ['system', 'light', 'dark'];

        let mode = 'system';

        try {
            const storedMode = window.localStorage.getItem(storageKey);

            if (validModes.includes(storedMode)) {
                mode = storedMode;
            }
        } catch {
            // Follow the system preference when storage is unavailable.
        }

        const isDark = mode === 'dark'
            || (mode === 'system'
                && window.matchMedia('(prefers-color-scheme: dark)').matches);

        document.documentElement.classList.toggle('dark', isDark);
        document.documentElement.dataset.theme = isDark ? 'dark' : 'light';
        document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';

        document
            .querySelectorAll('meta[name="theme-color"]')
            .forEach((meta) => {
                meta.content = isDark ? '#020617' : '#f8fafc';
            });
    })();
</script>
