@props(['active'])

@php
	$classes = ($active ?? false)
				? 'inline-flex items-center px-1 pt-1 border-b-2 border-orange-600 text-sm font-medium leading-5 text-orange-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
				: 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-orange-400 hover:text-orange-300 hover:border-orange-700 focus:outline-none focus:text-orange-300 focus:border-orange-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
	{{ $slot }}
</a>
