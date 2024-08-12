<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Log') }}
	</x-slot>

	<x-hero-profile :user="$user"/>
	@if ($questLogs->count() > 0)

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
					<th scope="col">Quest Title</th>
					<th scope="col">Status</th>
					<th scope="col" class="hidden md:table-cell">XP Awarded</th>
					<th scope="col" class="hidden md:table-cell">Bonus XP</th>
					<th scope="col">Date</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($questLogs as $questLog)
					<tr class="row-clickable" data-url="{{ route('quest-logs.review', $questLog) }}">
						<td>
							<a href="{{ route('quest-logs.review', $questLog) }}">{{ $questLog->quest->title }}</a>
						</td>
						<td>
							<span class="inline-flex items-center justify-center px-2 py-1 font-bold leading-none text-slate-800 rounded {{ $questLog->statusColor }}">{{$questLog->status }}</span>
						</td>
						<td class="hidden md:table-cell">{{ $questLog->xp_awarded }}</td>
						<td class="hidden md:table-cell">{{ $questLog->xp_bonus }}</td>
						<td>
							@if($questLog->completed_at)
								<x-date-user-time-zone :value="$questLog->completed_at" format="d M Y"/>
							@elseif($questLog->accepted_at)
								<x-date-user-time-zone :value="$questLog->created_at" format="d M Y"/>
							@else
								<x-date-user-time-zone :value="$questLog->accepted_at" format="d M Y"/>
							@endif
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
		{{ $questLogs->appends(request()->except('page'))->links() }}

	@else
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
			<p>{{ $user->name }} has not accepted any quests yet.</p>
		</div>
	@endif

</x-app-layout>