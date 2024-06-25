@props(['value', 'default', 'escape' => true])

@if (!empty($value))
	@if ($escape)
		{{ e($value) }}
	@else
		{!! Purifier::clean($value) !!}
	@endif
@else
	{!! $default !!}
@endif