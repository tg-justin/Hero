<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-seance-800 dark:text-seance-200 leading-tight">
            {{ __('Quest Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-700">
                    <h2 class="text-4xl font-extrabold mb-4">{{ $quest->title }}</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-lg font-semibold">Description:</p>
                            <p class="mt-2">{{ $quest->description }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold">Points:</p>
                            <p class="mt-2">{{ $quest->points }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold">Category:</p>
                            <p class="mt-2">{{ $quest->category->name }}</p>
                        </div>
                        @if ($quest->campaign)
                            <div>
                                <p class="text-lg font-semibold">Campaign:</p>
                                <p class="mt-2">{{ $quest->campaign->title }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-lg font-semibold">Repeatable:</p>
                            <p class="mt-2">{{ $quest->repeatable }}</p>
                        </div>
                    </div>

                    <div class="flex justify-end mt-8">
                        @if (Auth::user()->hasRole('manager'))
                            <a href="{{ route('quests.edit', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Edit Quest</a>
                        @endif

                        @if (Auth::user()->hasRole('hero'))
                            @if(1==1)
                                    <form action="{{ route('quests.accept', $quest->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">
                                            Accept Quest
                                        </button>
                                    </form>

                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
