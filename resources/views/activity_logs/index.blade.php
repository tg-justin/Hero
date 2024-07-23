<x-app-layout>
	<x-slot name="header">
		{{ __('Activity Log') }}
    </x-slot>

    <div class="main-table">
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
                    <td><x-date-user-time-zone :value="$activity->created_at"/></td>
                </tr>
            @empty

            @endforelse
            </tbody>
        </table>
	</div>
        {{ $activities->appends(request()->except('page'))->links() }}
</x-app-layout>