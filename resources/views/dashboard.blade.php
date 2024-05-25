<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-seance-800 dark:text-seance-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

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
