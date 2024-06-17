<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200">
            {{ __('Manager Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cover bg-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

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
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <h2 class="text-xl font-semibold px-6 py-3 bg-seance-800 text-white">Top Heroes</h2>
                <table class="min-w-full divide-y divide-seance-200">
                    <thead class="bg-seance-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Hero</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Level</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quests Completed</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                    @foreach ($topHeroes as $hero)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800">
                                <a href="{{ route('heroes.quest-logs', $hero) }}" class="text-seance-600 hover:text-seance-700">
                                    {{ $hero->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $hero->level }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $hero->quest_logs_count }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
