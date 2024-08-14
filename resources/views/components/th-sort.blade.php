@props(['route', 'sort', 'display' => null, 'class' => null, 'attrib' => null, 'params' => []])

@php
	$isSortedByField = request('sort') === $sort;
	$direction = $isSortedByField && request('direction') === 'asc' ? 'desc' : 'asc';
	$arrow = $isSortedByField ? (request('direction') === 'asc' ? '&darr;' : '&uarr;') : '';
	$class = ($class !== null) ? "class=\"$class\"" : '';
	$attrib = ($attrib !== null) ? $attrib : '';

	// Merge dynamic route parameters with sorting parameters
	$routeParams = array_merge($params, ['sort' => $sort, 'direction' => $direction]);
@endphp

<th scope="col" {!! $class !!} {!! $attrib !!}>
	<a href="{{ route($route, $routeParams + request()->except('sort', 'direction')) }}">
		{{ $display }} {!! $arrow !!}
	</a>
</th>