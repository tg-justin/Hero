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
			<h2>Greetings, Traveller!</h2>
			<p>We've been expecting you. You will need to complete the "<strong>Hero Registration</strong>" quest below before you can accept any other quests. Your legend awaits!</p>
		</div>
	@endif


	{{-- Quest Table --}}
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
				<x-th-sort route="quests.index" sort="min_level" display="Lvl"/>
				<x-th-sort route="quests.index" sort="title" display="Quest Title"/>
				<x-th-sort route="quests.index" sort="xp" display="XP" class="hidden md:table-cell"/>
				<x-th-sort route="quests.index" sort="expires_date" display="Expires" class="hidden md:table-cell"/>
			</tr>
			</thead>
			<tbody>
			@foreach ($quests as $quest)
				<tr class="row-clickable" data-url="{{ route('quests.show', $quest->id) }}">
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
						<x-date-user-time-zone :value="$quest->expires_date" format="d M Y"/>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{ $quests->appends(request()->except('page'))->links() }}
</x-app-layout>