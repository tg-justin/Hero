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
		'bg-blue-600',
		'bg-green-600',
		'bg-red-200',
		'bg-yellow-600',
		'bg-seance-600',
	],
	darkMode: 'class',  // Use 'class' strategy for dark mode
	theme: {
		extend: {
			fontFamily: {
				sans: ['Figtree', ...defaultTheme.fontFamily.sans],
			},
			colors: {
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
					'800': '#662d91', // Tabletop Gaymers Purple
					'900': '#59287b',
					'950': '#3c115a',
				},
				'orange': {
					'50': '#fef6ee',
					'100': '#fee9d6',
					'200': '#fbd0ad',
					'300': '#f9af78',
					'400': '#f58342',
					'500': '#f26522', // Tabletop Gaymers Orange
					'600': '#e34813',
					'700': '#bc3412',
					'800': '#962b16',
					'900': '#792615',
					'950': '#411009',
				},
				'forest': {
					'50': '#f2fbf3',
					'100': '#e0f8e3',
					'200': '#c3efca',
					'300': '#95e0a1',
					'400': '#5fc971',
					'500': '#39ae4d',
					'600': '#2c973e', // Tabletop Gaymers Green
					'700': '#247132',
					'800': '#215a2c',
					'900': '#1d4a26',
					'950': '#0b2811',
				},
				'red': {
					'50': '#fff0f0',
					'100': '#ffdddd',
					'200': '#ffc0c0',
					'300': '#ff9494',
					'400': '#ff5757',
					'500': '#ff2323',
					'600': '#ff0000', // RGB Red
					'700': '#d70000',
					'800': '#b10303',
					'900': '#920a0a',
					'950': '#500000',
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