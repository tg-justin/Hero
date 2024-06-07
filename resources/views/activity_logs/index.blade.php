<x-app-layout>


    <div class="py-12 bg-cover bg-center" style="background-image: url('{{ asset('images/parchment-background.jpg') }}');">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-2xl font-semibold text-seance-800 dark:text-seance-200 mb-4">Recent Happenings in the Realm</h3>

                <table class="min-w-full divide-y divide-seance-200">
                    <thead class="bg-seance-800 text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Subject</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Performed By</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Date</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                    @forelse ($activities as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-seance-800">{{ $activity->description }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $activity->subject_display_name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $activity->causer ? $activity->causer->name : 'System' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty

                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

