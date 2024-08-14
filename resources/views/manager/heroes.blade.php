@php
	use Carbon\Carbon;
@endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Management') }}
	</x-slot>

	{{-- Search Form --}}
	<div class="main-search">
		<form action="{{ route('manager.heroes') }}" method="GET">
			<div class="flex items-center space-x-4">
				<div class="md:flex-grow">
					<input type="text" name="search" id="search" class="search-box" aria-label="Search by name or email"
						   placeholder="Search by name or email" value="{{ request('search') }}" autofocus>
				</div>
				<button type="submit" class="button-submit">Search</button>
			</div>
		</form>
	</div>


	{{-- Hero Table --}}
	<script>
		$(function () {
			$('table.table-clickable').on("click", "tr.row-clickable", function () {
				window.location = $(this).data("url");
				//alert($(this).data("url"));
			});
		});
	</script>
	<div class="main-table">
		<table class="table-seance table-clickable">
			<thead>
			<tr>
				<x-th-sort route="manager.heroes" sort="name" display="Hero"/>
				<x-th-sort route="manager.heroes" sort="level" display="Lvl"/>
				<x-th-sort route="manager.heroes" sort="email" display="Email"/>
				<th>Role(s)</th>
				<x-th-sort route="manager.heroes" sort="last_login_at" display="Last Sign In"/>
			</tr>
			</thead>
			<tbody>
			@foreach ($heroes as $hero)
				<tr class="row-clickable" data-url="{{ route('profile.show-profile', ['heroId' => $hero->id]) }}">
					<td><a href="{{ route('profile.show-profile', ['heroId' => $hero->id]) }}">{{ $hero->name }}</a></td>
					<td>{{ $hero->level }}</td>
					<td>{{ $hero->email }}</td>
					<td>{{ ucwords(trim($hero->roles->pluck('name')->implode(', '))) }}</td>
					<td class="whitespace-nowrap">
						<x-date-user-time-zone :value="$hero->last_login_at" format="d M Y"/>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

</x-app-layout>