@props(['value', 'format' => null, 'timeZone' => null])

@php
	use Carbon\Carbon;

	$user = auth()->user();
	$timeZone = $timeZone ?? $user->timezone ?? 'UTC';

	if (!$format) {
		$format = strpos($value, ':') ? 'd M Y h:i a' : 'd M Y';
	}

	$date = Carbon::parse($value)->timezone($timeZone)->format($format);
@endphp

{{ $date }}