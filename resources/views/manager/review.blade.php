@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">Quest Logs: Pending Review</x-slot>

	@if ($questLogs->count() == 0)
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
			No quest logs pending review.
		</div>
	@else
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
					<th scope="col">ID</th>
					<x-th-sort route="manager.review" sort="users.name" display="Hero"/>
					<x-th-sort route="manager.review" sort="quests.title" display="Quest"/>
					<x-th-sort route="manager.review" sort="completed_at" display="Completed"/>
					<th scope="col">Actions</th>
				</tr>
				</thead>
				<tbody class="bg-white divide-y divide-slate-200">
				@foreach ($questLogs as $questLog)
					<tr class="row-clickable" data-url="{{ route('quest-logs.review', $questLog) }}">
						<td>{{ $questLog->id }}</td>
						<td>{{ $questLog->user->name }}</td>
						<td>{{ $questLog->quest->title }}</td>
						<td>
							<x-date-user-time-zone :value="$questLog->completed_at" format="d M Y"/>
						</td>
						<td><a href="{{ route('quest-logs.review', $questLog) }}">Review</a></td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $questLogs->appends(request()->except('page'))->links() }}
	@endif
</x-app-layout>