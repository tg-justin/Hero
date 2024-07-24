@props(['color' => false, 'href' => ''])

@php
    $classes = "tg-button-" . $color;
	$href = $href ? $href : '#';
@endphp

<span>
	<a href="{{ $href }}" {{ $attributes->merge(['class' => "tg-button-$color"]) }}>
    	{{ $slot }}
	</a>
</span>