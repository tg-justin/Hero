@props(['active' => false, 'mobile' => false])

@php
    $classes = ($mobile)
                ? 'block w-full ps-3 pe-4 py-2 border-l-4  '
                : 'inline-flex items-center px-1 pt-1 border-b-4 ';

    $classes .= 'text-base font-bold  '
        . 'transition duration-150 ease-in-out '
        . 'hover:text-orange-500 hover:border-orange-700 hover:underline-offset-4 '
        . 'focus:text-blue-300   focus:border-blue-700 ';

    $classes .= ($active)
            ? 'border-orange-600  text-orange-50 '
            : 'border-transparent text-orange-300 bg-transparent ';

    $classes .= ($active && $mobile)
            ? 'bg-orange-900/50 '
            : ' ';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>