<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-800 dark:text-seance-200 leading-tight">
            {{ __('Quest Details') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-cover bg-center" style="background-image: url('{{ asset('images/parchment-background.jpg') }}');">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">  {{-- Adjusted background and added padding --}}

                <h2 class="text-4xl font-extrabold mb-4 text-seance-800">{{ $quest->title }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-md shadow-inner">  {{-- Added card effect to summary/description --}}
                            <p class="text-lg font-semibold text-seance-800">Summary:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->summary }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-md shadow-inner">  {{-- Added card effect to summary/description --}}
                            <p class="text-lg font-semibold text-seance-800">Description:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->description }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <div class="flex items-center mb-2"> 
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.736 5.943 5.522 3 10 3s8.264 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.736 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <p class="text-lg font-semibold text-seance-800">Points:</p>
                            </div>
                            <p class="mt-2 text-seance-700">{{ $quest->points }}</p>
                        </div>
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Category:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->category->name }}</p>
                        </div>
                        @if ($quest->campaign)
                            <div class="bg-white p-4 rounded-md shadow-inner">
                                <p class="text-lg font-semibold text-seance-800">Campaign:</p>
                                <p class="mt-2 text-seance-700">{{ $quest->campaign->title }}</p>
                            </div>
                        @endif
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Repeatable:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->repeatable }}</p>
                            <p class="mt-2 text-seance-700">{{ $quest->repeatable_text }}</p>
                        </div>

                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Additional Details:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->fine_print }}</p>
                            <p class="mt-2 text-seance-700">{{ $quest->turn_in_text }}</p>
                        </div>
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
</x-app-layout>

