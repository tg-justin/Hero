<x-app-layout>
	<x-slot name="header">Quest Report: Summary</x-slot>


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
				<th>Lvl</th>
				<th>Quest Name</th>
				<th>Acc</th>
				<th>Comp</th>
				<th>Drop</th>
				<th>Total Hrs</th>
				<th>Ave Hrs</th>
			</tr>
			</thead>
			<tbody>
			@foreach($quests as $quest)
				<tr class="row-clickable" data-url="{{ route('quests.quest-logs', $quest) }}">
					<td>{{ $quest->min_level }}</td>
					<td><a href="{{ route('quests.quest-logs', $quest) }}">{{ $quest->title }}</a></td>
					<td>{{ $quest->accepted_count }}</td>
					<td>{{ $quest->completed_count }}</td>
					<td>{{ $quest->dropped_count }}</td>
					<td>{{ round($quest->total_time_spent/60, 1) }}</td>
					<td>{{ round($quest->avg_time_spent/60, 1) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>

</x-app-layout>