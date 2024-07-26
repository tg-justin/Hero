@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Logs for: ') }} {{ $quest->title }}
	</x-slot>
	@if($questLogs->count() > 0)

		<div class="main-table">
			<table class="table-seance">
				<thead>
				<tr>
					<th scope="col">
						<a href="{{ route('quests.quest-logs', ['quest' => $quest, 'sort' => 'name', 'direction' => ($sortBy === 'name' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}">
							Hero
							@if ($sortBy === 'name')
								{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">
						<a href="{{ route('quests.quest-logs', ['quest' => $quest, 'sort' => 'status', 'direction' => ($sortBy === 'status' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}">
							Status
							@if ($sortBy === 'status')
								{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">
						<a href="{{ route('quests.quest-logs', ['quest' => $quest, 'sort' => 'review', 'direction' => ($sortBy === 'review' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}">
							Needs Review
							@if ($sortBy === 'review')
								{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">
						Files
					</th>
					<th scope="col">
						Feedback
					</th>
					<th scope="col">
						<a href="{{ route('quests.quest-logs', ['quest' => $quest, 'sort' => 'completed_at', 'direction' => ($sortBy === 'completed_at' && $sortDirection === 'asc') ? 'desc' : 'asc']) }}">
							Completed At
							@if ($sortBy === 'completed_at')
								{!! (request('direction') === 'asc') ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					{{-- Add more columns as needed --}}
				</tr>
				</thead>
				<tbody>
				@foreach ($questLogs as $questLog)
					<tr>
						<td>
							<a href="{{ route('quest-logs.review', $questLog->quest_log_id) }}">
								{{ $questLog->user->name }}
							</a>
						</td>
						<td>{{ $questLog->status }}</td>
						<td>{{ $questLog->review ? 'Yes' : 'No' }}</td>
						<td>
							{{ $questLog->files->count() }}
						</td>
						<td>
							{{ $questLog->feedback_size }}
						</td>
						<td>
							<x-date-user-time-zone :value="$questLog->completed_at" format="d M Y (h:i A)"/>
						</td>
						{{-- Add more cells as needed --}}
					</tr>
				@endforeach
				</tbody>
			</table>

			{{ $questLogs->links() }}
		</div>
	@else
		<div class="block rounded-lg shadow-lg p-4 bg-gradient-to-br from-yellow-50 to-yellow-200">
			<p>No quest logs have been submitted for this quest yet.</p>
		</div>
	@endif
</x-app-layout>
