import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                brand: {
                    primary:
                        'rgb(var(--brand-primary) / <alpha-value>)',

                    'primary-light':
                        'rgb(var(--brand-primary-light) / <alpha-value>)',

                    'primary-dark':
                        'rgb(var(--brand-primary-dark) / <alpha-value>)',

                    secondary:
                        'rgb(var(--brand-secondary) / <alpha-value>)',

                    'secondary-light':
                        'rgb(var(--brand-secondary-light) / <alpha-value>)',

                    'secondary-dark':
                        'rgb(var(--brand-secondary-dark) / <alpha-value>)',

                    accent:
                        'rgb(var(--brand-accent) / <alpha-value>)',
                },
            },

            fontFamily: {
                sans: [
                    'Figtree',
                    ...defaultTheme.fontFamily.sans,
                ],
            },
        },
    },

    plugins: [
        forms,
    ],
};
