@props(['messages'])

@if ($messages)
	<ul {{ $attributes->merge(['class' => 'error-message']) }}>
		@foreach ((array) $messages as $message)
			<li>{{ $message }}</li>
		@endforeach
	</ul>
@endif