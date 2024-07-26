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

	<div class="main-table">
		<table class="table-seance">
			<thead>
			<tr>
				<th class="tracking-wider">ID</th>
				<th class="tracking-wider">Name</th>
				<th class="tracking-wider">Email</th>
				<th class="tracking-wider">Role(s)</th>
				<th class="tracking-wider">Last Sign In</th>
				<th class="tracking-wider">Actions</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($heroes as $hero)
				<tr>
					<td>{{ $hero->id }}</td>
					<td>
						<a href="{{ route('profile.show-profile', ['heroId' => $hero->id]) }}">{{ $hero->name }}</a>
					</td>
					<td>{{ $hero->email }}</td>
					<td>{{ ucwords(trim($hero->roles->pluck('name')->implode(', '))) }}
					</td>
					<td class="whitespace-nowrap">
						@if ($hero->last_login_at)
							<x-date-user-time-zone :value="$hero->last_login_at" format="d M Y"/>
						@else
							&mdash;
						@endif
					</td>
					{{--TODO idk how this variable works--}}
					{{--								<td>--}}
					{{--									 @if (!$hero->is_active)--}}
					{{--										 Active--}}
					{{--									 @else--}}
					{{--										 Inactive--}}
					{{--									 @endif--}}
					{{--								</td>--}}
					<td>
						@if($hero->hasRole('hero') && !$hero->hasRole('manager'))
							<form action="{{ route('heroes.promote', $hero->id) }}" method="POST" class="inline">
								@csrf
								<button type="submit" class="text-green-600 hover:text-green-900">Promote to Manager</button>
							</form>
						@endif
						{{--<form action="{{ route('heroes.toggle-active', $hero->id) }}" method="POST" class="inline">
							@csrf
							<button type="submit" class="text-{{ $hero->is_active ? 'red' : 'green' }}-600 hover:text-{{ $hero->is_active ? 'red' : 'green' }}-900">
								{{ $hero->is_active ? 'Deactivate' : 'Activate' }}
							</button>
						</form>--}}
						<form action="{{ route('manager.heroes.sendPasswordReset', $hero->id) }}" method="POST" class="inline">
							@csrf
							<button type="submit" class="text-yellow-600 hover:text-yellow-900">Send Password Reset</button>
						</form>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

</x-app-layout>