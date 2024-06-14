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
        'bg-blue-200',
        'bg-green-200',
        'bg-red-200',
        'bg-yellow-200',
        'bg-seance-200',
    ],
    darkMode: 'class',  // Use 'class' strategy for dark mode
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
			colors:{
                'accent': '#f26522',
                'primary': '#9547d6',
				'seance': {
					'50': '#faf6fe',
					'100': '#f3eafd',
					'200': '#eadafa',
					'300': '#d9bcf6',
					'400': '#c291ef',
					'500': '#ab67e5',
					'600': '#9547d6',
					'700': '#8035bb',
					'800': '#662d91',
					'900': '#59287b',
					'950': '#3c115a',
				},
                'orange': {
                    '50': '#fef6ee',
                    '100': '#fee9d6',
                    '200': '#fbd0ad',
                    '300': '#f9af78',
                    '400': '#f58342',
                    '500': '#f26522',
                    '600': '#e34813',
                    '700': '#bc3412',
                    '800': '#962b16',
                    '900': '#792615',
                    '950': '#411009',
                },

            },
        },
    },

    plugins: [forms],
    // Disable Preflight
    corePlugins: {
        preflight: true,
    },
};
