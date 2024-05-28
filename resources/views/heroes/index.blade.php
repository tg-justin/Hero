<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-seance-800 dark:text-seance-200 leading-tight">
            {{ __('Heroes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Search Form --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4 p-6 text-gray-900">
                <form action="{{ route('heroes.index') }}" method="GET">
                    <div class="flex items-center">
                        <label for="search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </div>
                            <input type="text" id="search" name="search" class="block p-2 pl-10 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search heroes..." value="{{ request('search') }}">
                        </div>
                        <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-seance-700 rounded-lg border border-seance-700 hover:bg-seance-800 focus:ring-4 focus:outline-none focus:ring-seance-300 dark:bg-seance-600 dark:hover:bg-seance-700 dark:focus:ring-seance-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Hero Cards --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($heroes as $hero)
                            <div class="bg-white rounded-lg shadow-md p-4">
                                <h3 class="text-lg font-semibold text-gray-800">{{ $hero->name }}</h3>
                                <p class="text-sm text-gray-600">Level: {{ $hero->level ?? 'N/A' }}</p>
                                <p class="text-sm text-gray-600">Total Points: {{ $hero->totalPoints() }}</p>
                                <p class="text-sm text-gray-600">Completed Quests: {{ $hero->completedQuests()->count() }}</p>

                                <a href="{{ route('users.quest-logs', $hero) }}" class="mt-4 inline-block bg-seance-700 hover:bg-seance-800 text-white font-bold py-2 px-4 rounded">
                                    View Quest Log
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
