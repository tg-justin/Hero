<x-app-layout>
    <div class="py-12 bg-cover bg-center" style="background-image: url('{{ asset('images/parchment-background.jpg') }}');">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            {{-- Display success message --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="overflow-hidden shadow-xl rounded-lg">
                <x-hero-profile :user="$user" />
                @if ($questLogs->count() > 0)
                    <table class="min-w-full divide-y divide-seance-200">
                        <thead class="bg-seance-800 text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quest Title</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">XP Awarded</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Bonus XP</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                        @foreach ($questLogs as $questLog)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800 hover:text-seance-700">
                                    <a href="{{ route('quests.show', $questLog->quest->id) }}">
                                        {{ $questLog->quest->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-slate-600 rounded {{ $questLog->statusColor }}">
                                        {{ $questLog->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $questLog->xp_awarded }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $questLog->xp_bonus }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('quest-logs.edit', $questLog) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                        <p>{{ $user->name }} has not accepted any quests yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

