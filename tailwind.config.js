import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    safelist: [
        'from-blue-500', 'to-blue-600',
        'from-purple-500', 'to-purple-600',
        'from-emerald-500', 'to-emerald-600',
        'from-amber-500', 'to-amber-600',
        'from-rose-500', 'to-rose-600',
        'from-cyan-500', 'to-cyan-600',
        'bg-gradient-to-br',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
