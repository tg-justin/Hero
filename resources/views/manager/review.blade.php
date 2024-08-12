@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Logs for Review') }}
	</x-slot>

	@if ($questLogs->count() > 0)



		{{-- Review Table --}}
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
					<th scope="col">
						<a href="{{ route('manager.review', ['sort_by' => 'user_id', 'sort_direction' => $sortBy === 'user_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
							User
							@if ($sortBy === 'user_id')
								{!! $sortDirection === 'asc' ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">
						<a href="{{ route('manager.review', ['sort_by' => 'quest_id', 'sort_direction' => $sortBy === 'quest_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
							Quest
							@if ($sortBy === 'quest_id')
								{!! $sortDirection === 'asc' ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">
						<a href="{{ route('manager.review', ['sort_by' => 'completed_at', 'sort_direction' => $sortBy === 'completed_at' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
							Completed
							@if ($sortBy === 'completed_at')
								{!! $sortDirection === 'asc' ? "&darr;" : "&uarr;"  !!}
							@endif
						</a>
					</th>
					<th scope="col">Actions</th>
				</tr>
				</thead>
				<tbody class="bg-white divide-y divide-slate-200">
				@foreach ($questLogs as $questLog)
					<tr class="row-clickable" data-url="{{ route('quest-logs.review', $questLog) }}">
						<td>{{ $questLog->user->name }}</td>
						<td>{{ $questLog->quest->title }}</td>
						<td><x-date-user-time-zone :value="$questLog->completed_at" format="d M Y"/></td>
						<td><a href="{{ route('quest-logs.review', $questLog) }}">Review</a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $questLogs->appends(request()->except('page'))->links() }}
	@else
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
			<p>No quest logs pending review.</p>
		</div>
	@endif

	<div id="questLogModal" class="hidden"></div>

</x-app-layout>