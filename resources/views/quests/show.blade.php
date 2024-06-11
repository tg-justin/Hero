<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200 leading-tight">
            {{ __('Quest Details') }}
        </h2>
    </x-slot>



    @php
        $questLog = Auth::user()->questLogs()->where('quest_id', $quest->id)->first();
    @endphp
    <div class="py-12 bg-cover bg-center"
         >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">

                <h2 class="text-4xl font-extrabold mb-4 text-seance-800">{{ $quest->title }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="space-y-4 quest_body">
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">[INTRODUCTION]</p>
                            <p class="mt-2 text-seance-700">{!! $quest->intro_text !!}</p>
                        </div>

                        @if (!$questLog || Auth::user()->hasRole('manager'))
                            <div class="bg-white p-4 rounded-md shadow-inner">
                                <p class="text-lg font-semibold text-seance-800">[ACCEPT]</p>
                                <p class="mt-2 text-seance-700">{!!$quest->accept_text !!}</p>
                            </div>
                        @endif
                        @if ($questLog || Auth::user()->hasRole('manager'))
                            <div class="bg-white p-4 rounded-md shadow-inner">
                                <p class="text-lg font-semibold text-seance-800">[DIRECTIONS]</p>
                                <p class="mt-2 text-seance-700">{!! $quest->directions_text !!}</p>
                            </div>
                        @endif
                        @if ($questLog || Auth::user()->hasRole('manager'))
                            <div class="bg-white p-4 rounded-md shadow-inner">
                                <p class="text-lg font-semibold text-seance-800">[Complete]</p>
                                <p class="mt-2 text-seance-700">{!! $quest->complete_text !!}</p>
                            </div>
                        @endif
                    </div>

                    <div class="space-y-4 quest_body">
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Level: {{ $quest->min_level }}</p>

                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 mr-2"
                                     viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                    <path fill-rule="evenodd"
                                          d="M.458 10C1.736 5.943 5.522 3 10 3s8.264 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.736 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                          clip-rule="evenodd"/>
                                </svg>
                                <p class="text-lg font-semibold text-seance-800">XP Award: {{ $quest->xp }}</p>
                            </div>

                            {{-- if bonus_xp is not null, display the bonus_xp--}}
                            @if ($quest->bonus_xp_text)
                                <p class="text-sm text-seance-800"> {!! $quest->bonus_xp_text !!}</p>
                            @endif

                        </div>
                     {{--   <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Category:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->category->name }}</p>
                        </div>--}}
                       {{-- @if ($quest->campaign)
                            <div class="bg-white p-4 rounded-md shadow-inner">
                                <p class="text-lg font-semibold text-seance-800">Campaign:</p>
                                <p class="mt-2 text-seance-700">{{ $quest->campaign->title }}</p>
                            </div>
                        @endif--}}
                        {{--<div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Repeatable:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->repeatable }}</p>

                        </div>--}}

                       {{-- <div class="bg-white p-4 rounded-md shadow-inner">
                            <p class="text-lg font-semibold text-seance-800">Additional Details:</p>
                            <p class="mt-2 text-seance-700">{{ $quest->bonus_xp_text }}</p>
                            <p class="mt-2 text-seance-700">{{ $quest->complete_text }}</p>
                        </div>--}}
                    </div>
                </div>

                <div class="flex justify-end mt-8">
                    @if (Auth::user()->hasRole('manager'))
                        <a href="{{ route('quests.edit', $quest->id) }}"
                           class="mt-2 px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">Edit
                            Quest</a>
                    @endif

                    @if (Auth::user()->hasRole('hero'))

                        @if ($questLog && $questLog->status === 'accepted')
                                @if($quest->id == 1)
                                    <a href="{{ route('profile.hero-registration') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                        Hero Registration
                                    </a>
                                @else
                                    <a href="{{ route('quest-log.complete-form', $questLog) }}"
                                       class="mt-2 px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">
                                        Complete Quest
                                    </a>
                            @endif
                        @elseif($questLog && $questLog->status === 'completed')
                            <p class="mt-2 px-4 py-2 text-seance-600 bg-white rounded-md">
                                Quest Completed
                            </p>
                        @elseif (!$questLog)
                            <form action="{{ route('quests.accept', $quest->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">
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

