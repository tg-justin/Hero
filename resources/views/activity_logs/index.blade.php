<x-app-layout>
	<x-slot name="header">
		{{ __('Activity Log') }}
	</x-slot>

	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">
				<h3 class="text-2xl font-semibold text-seance-200 mb-4">Recent Happenings in the Realm</h3>
				<div class="overflow-x-auto shadow-xl rounded-lg">
					<table class="table-seance">
						<thead>
						<tr>
							<th scope="col" class="tracking-wider">Description</th>
							<th scope="col" class="tracking-wider">Subject</th>
							<th scope="col" class="tracking-wider">Performed By</th>
							<th scope="col" class="tracking-wider">Date</th>
						</tr>
						</thead>
						<tbody class="bg-white divide-y divide-slate-200">
						@forelse ($activities as $activity)
							<tr>
								<td>{{ $activity->description }}</td>
								<td>{{ $activity->subject_display_name }}</td>
								<td>{{ $activity->causer ? $activity->causer->name : 'System' }}</td>
								<td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
							</tr>
						@empty

						@endforelse
						</tbody>
					</table>
				</div>
				{{ $activities->appends(request()->except('page'))->links() }}
			</div>
		</div>
	</div>
</x-app-layout>