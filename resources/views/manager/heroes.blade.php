<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Management') }}
	</x-slot>

	<div class="max-w-7xl mx-auto px-2 lg:px-8">
		<div class="py-6 bg-cover bg-center">
			{{-- Search Form --}}
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6 text-gray-900">
				<form action="{{ route('manager.heroes') }}" method="GET">
					<div class="flex items-center">
						<label for="search" class="sr-only">Search</label>
						<div class="relative w-full">
							<div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
								<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
								</svg>
							</div>
							<input type="text" id="search" name="search" class="block p-2 pl-10 w-full text-sm rounded-lg border bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500"
								   placeholder="Search heroes..." value="{{ request('search') }}">
						</div>
						<button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white  rounded-lg border border-seance-700 focus:ring-4 focus:outline-none bg-seance-600 hover:bg-seance-700 focus:ring-seance-800">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
							</svg>
							<span class="sr-only">Search</span>
						</button>
					</div>
				</form>
			</div>
			<div class="bg-white overflow-hidden shadow-xl rounded-lg">
				<div class="overflow-x-auto shadow-xl rounded-lg">
					<table class="table-seance">
						<thead>
						<tr>
							<th class="tracking-wider">Name</th>
							<th class="tracking-wider">Email</th>
							<th class="tracking-wider">Role</th>
							<th class="tracking-wider">Last Login</th>
							<th class="tracking-wider">Actions</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($heroes as $hero)
							<tr>
								<td>
									@if($hero->hasRole('hero'))
										<a href="{{ route('manager.quest-logs', ['user' => $hero->id]) }}">
											{{ $hero->name }}
										</a>
									@else
										{{ $hero->name }}
									@endif
								</td>
								<td>{{ $hero->email }}</td>
								<td>{{ ucwords(trim($hero->roles->pluck('name')->implode(', '))) }}
								</td>
								<td>
									{{--TODO idk how this variable works--}}
									{{-- @if (!$hero->is_active)
										 Active
									 @else
										 Inactive
									 @endif--}}
									{{ $hero->last_login_at }}
								</td>
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
			</div>
		</div>
	</div>
</x-app-layout>