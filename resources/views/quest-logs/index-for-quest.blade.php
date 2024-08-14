@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Logs for: ') }} {{ $quest->title }}
	</x-slot>
	@if($questLogs->count() > 0)
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
					<x-th-sort route="quests.quest-logs" :params="['quest' => $quest]" sort="name" display="Hero"/>
					<x-th-sort route="quests.quest-logs" :params="['quest' => $quest]" sort="status" display="Status"/>
					<x-th-sort route="quests.quest-logs" :params="['quest' => $quest]" sort="review" display="Review"/>
					<th scope="col">Files</th>
					<th scope="col">Feedback</th>
					<x-th-sort route="quests.quest-logs" :params="['quest' => $quest]" sort="completed_at" display="Completed"/>
				</tr>
				</thead>
				<tbody>
				@foreach ($questLogs as $questLog)
					<tr class="row-clickable" data-url="{{ route('quest-logs.review', $questLog->quest_log_id) }}">
						<td><a href="{{ route('quest-logs.review', $questLog->quest_log_id) }}">{{ $questLog->user->name }}</a></td>
						<td>{{ $questLog->status }}</td>
						<td>{{ $questLog->review ? 'Yes' : 'No' }}</td>
						<td>{{ $questLog->files->count() }}</td>
						<td>{{ $questLog->feedback_size }}</td>
						<td>
							<x-date-user-time-zone :value="$questLog->completed_at" format="d M Y (h:i A)"/>
						</td>
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