@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Board') }}
	</x-slot>
	<x-slot name="headerRight">
		@if (Auth::user()->hasRole('manager'))
			<a href="{{ route('quests.create') }}" class="header-button">NEW QUEST</a>
		@endif
	</x-slot>

	{{-- Search and Filter Form --}}
	@if(Auth::user()->level > 0)
		<div class="main-search">
			<form action="{{ route('quests.index') }}" method="GET">
				<div class="flex items-center space-x-4">
					<div class="md:flex-grow">
						<input type="text" name="search" id="search" class="search-box" aria-label="Search by title"
							   placeholder="Search by title" value="{{ request('search') }}" autofocus>
					</div>
					<label for="show_completed">
						<input type="checkbox" name="show_completed" id="show_completed" {{ $showCompleted ? 'checked' : '' }} onchange="this.form.submit()">
						Show Completed
					</label>
					<button type="submit" class="button-submit">Search</button>
				</div>
			</form>
		</div>
	@else
		<div class="mb-4 bg-white p-4 rounded-md shadow-md">
			<h2>Greetings, {{ Auth::user()->name }}!</h2>
			<p>We've been expecting you. Take a look around the quest board and select a task that speaks to your heart. Your legend awaits!</p>
		</div>
	@endif

	{{-- Quest Table --}}
	<div class="main-table">
		<table class="table-seance">
			<thead>
			<tr>
				<th scope="col">
					<a href="{{ route('quests.index', ['sort' => 'min_level', 'direction' => request('sort') === 'min_level' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
						Lvl
						@if (request('sort') === 'min_level')
							{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
						@endif
					</a>
				</th>
				<th scope="col">
					<a href="{{ route('quests.index', ['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
						Quest Title
						@if (request('sort') === 'title')
							{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
						@endif
					</a>
				</th>

				<th scope="col" class="hidden md:table-cell">
					<a href="{{ route('quests.index', ['sort' => 'xp', 'direction' => request('sort') === 'xp' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
						XP
						@if (request('sort') === 'xp')
							{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
						@endif
					</a>
				</th>
				<th scope="col" class="hidden md:table-cell">
						<a href="{{ route('quests.index', ['sort' => 'expires_date', 'direction' => request('sort') === 'expires_date' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}">
						Expires
						@if (request('sort') === 'expires_date')
								{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
						@endif
					</a>
				</th>
			</tr>

			</thead>
			<tbody>
			@foreach ($quests as $quest)
				<tr>
					<td>{{ $quest->min_level }}</td>
					<td>
						@if ($quest->questLogs->isNotEmpty())
							<span class="">&#10004;</span>
						@endif
						<a href="{{ route('quests.show', $quest->id) }}">
							{{ $quest->title }}
						</a>
					</td>

					<td class="hidden md:table-cell">{{ $quest->xp }}</td>
					<td class="hidden md:table-cell whitespace-nowrap">
						@if($quest->expires_date)
							<x-date-user-time-zone :value="$quest->expires_date" format="d M Y"/>
						@else
							&mdash;
						@endif
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{ $quests->appends(request()->except('page'))->links() }}
</x-app-layout>