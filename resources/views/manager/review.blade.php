@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Logs for Review') }}
	</x-slot>

	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			@if (session('success'))
				<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			@if ($questLogs->count() > 0)
				<div class="overflow-x-auto shadow-xl rounded-lg">
					<table class="table-seance">
						<thead>
						<tr>
							<th class="tracking-wider">
								<a href="{{ route('manager.review', ['sort_by' => 'user_id', 'sort_direction' => $sortBy === 'user_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
									User
									@if ($sortBy === 'user_id')
										<i class="fas fa-sort{{ $sortDirection === 'asc' ? '-up' : '-down' }}"></i>
									@endif
								</a>
							</th>
							<th class="tracking-wider">
								<a href="{{ route('manager.review', ['sort_by' => 'quest_id', 'sort_direction' => $sortBy === 'quest_id' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
									Quest
									@if ($sortBy === 'quest_id')
										<i class="fas fa-sort{{ $sortDirection === 'asc' ? '-up' : '-down' }}"></i>
									@endif
								</a>
							</th>
							<th class="tracking-wider">
								<a href="{{ route('manager.review', ['sort_by' => 'completed_at', 'sort_direction' => $sortBy === 'completed_at' && $sortDirection === 'asc' ? 'desc' : 'asc']) }}">
									Completed At
									@if ($sortBy === 'completed_at')
										<i class="fas fa-sort{{ $sortDirection === 'asc' ? '-up' : '-down' }}"></i>
									@endif
								</a>
							</th>
							<th class="tracking-wider">Actions</th>
						</tr>
						</thead>
						<tbody class="bg-white divide-y divide-slate-200">
						@foreach ($questLogs as $questLog)
							<tr>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
									<a href="{{ route('manager.quest-logs', $questLog->user) }}" class="text-seance-600 hover:text-seance-700">
										{{ $questLog->user->name }}
									</a>
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
									{{ $questLog->quest->title }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
									{{ Carbon::parse($questLog->completed_at)->format('d M Y') }}
								</td>
								<td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
									<a href="{{ route('quest-logs.review', $questLog) }}" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Review</a>
								</td>

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
		</div>
	</div>


</x-app-layout>