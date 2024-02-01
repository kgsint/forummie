import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: ({ theme }) => ({
                DEFAULT: {
                  css: {
                    '--tw-prose-bullets': theme('colors.gray.600'),
                    '--tw-prose-quote-borders': theme('colors.gray.500'),
                    li: {
                        margin: 0,
                        padding: 0,
                    }
                  },
                },
              }),
        },
    },

    plugins: [forms, typography],
};
