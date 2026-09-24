import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#faf6f1',
                    100: '#f0e6d8',
                    200: '#e4d3b8',
                    300: '#d3b78d',
                    400: '#c19a68',
                    500: '#a97e4f',
                    600: '#8f6540',
                    700: '#6b4a2f',
                    800: '#4a3320',
                    900: '#2e1f14',
                },
                cream: '#ede4d8',
            },
        },
    },

    plugins: [forms],
};