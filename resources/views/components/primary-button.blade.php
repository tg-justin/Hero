<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-seance-800 dark:bg-seance-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-seance-800 uppercase
tracking-widest hover:bg-seance-700 dark:hover:bg-white focus:bg-seance-700 dark:focus:bg-white active:bg-seance-900 dark:active:bg-seance-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-seance-800 transition ease-in-out duration-150']) }}>
	{{ $slot }}
</button>
