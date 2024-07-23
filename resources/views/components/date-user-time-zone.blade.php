@props(['value', 'format' => null, 'timeZone' => null])

{{-- <x-date-user-time-zone :value="$hero->last_login_at"/> --}}
{{-- <x-date-user-time-zone :value="$hero->last_login_at" format="d M Y"/> --}}
{{-- <x-date-user-time-zone :value="$hero->last_login_at" format="d M Y" timeZone="America/Chicago"/> --}}

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