<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-800 dark:text-seance-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if ($userQuestLog->count() == 0)
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-seance-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-seance-900 dark:text-seance-100">
                        Visit the Quest Board to get started!
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="py-12 bg-cover bg-center" style="background-image: url('{{ asset('images/parchment-background.jpg') }}');">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- Top Heroes --}}
            <x-hero-list :heroes="$topHeroes" title="Top Heroes" />

            {{-- Leaderboard --}}
            <x-leaderboard :heroes="$leaderboard" />

            {{-- Quests by Category --}}
            <x-quests-by-category :questsByCategory="$questsByCategory" />

            {{-- News and Announcements --}}
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4">News & Announcements</h3>
                <ul class="list-disc pl-5">
                    @foreach($news as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>



<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-seance-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-seance-900 dark:text-seance-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-seance-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-seance-900 dark:text-seance-100">
                    Visit the Quest Board to get started!
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
