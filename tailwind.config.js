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

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
			colors:{
                'accent': '#f3eafd',
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
			},
        },
    },

    plugins: [forms],
};
