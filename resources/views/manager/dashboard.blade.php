<x-app-layout>
	<x-slot name="header">
		{{ __('Manager Dashboard') }}
	</x-slot>

	{{-- Key Statistics --}}
	<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Total Active Heroes</h3>
			<p class="text-2xl font-bold">{{ $totalActiveHeroes }}</p>
		</div>
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Unaccepted Quests</h3>
			<p class="text-2xl font-bold">{{ $unacceptedQuests }}</p>
		</div>
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Unreviewed Quest Logs</h3>
			<p><a class="text-2xl font-bold" href="{{ route('manager.review') }}">{{ $unreviewedQuestLogs }}</a>
			</p>
		</div>
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Quests Completed Today</h3>
			<p class="text-2xl font-bold">{{ $questsCompletedToday }}</p>
		</div>
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Quests Completed This Week</h3>
			<p class="text-2xl font-bold">{{ $questsCompletedThisWeek }}</p>
		</div>
		<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
			<h3 class="text-lg font-semibold mb-2">Quests Completed This Month</h3>
			<p class="text-2xl font-bold">{{ $questsCompletedThisMonth }}</p>
		</div>
	</div>

	{{-- Top Heroes --}}
	<div class="main-table">
		<table class="table-seance">
			<thead class="bg-seance-800 text-white">
			<tr>
				<th>Top Heroes</th>
				<th>Level</th>
				<th>Quests Completed</th>
				<th>Last Login</th>
			</tr>
			</thead>
			<tbody>
			@foreach ($topHeroes as $hero)
				<tr>
					<td><a href="{{ route('manager.quest-logs', $hero) }}">{{ $hero->name }}</a></td>
					<td>{{ $hero->level }}</td>
					<td>{{ $hero->quest_logs_count }}</td>
					<td><x-date-user-time-zone :value="$hero->last_login_at"/></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</x-app-layout>