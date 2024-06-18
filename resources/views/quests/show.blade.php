<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200 leading-tight">
            {{ __('Quest Details') }}
        </h2>
    </x-slot>

    @php
        $questLog = Auth::user()->questLogs()->where('quest_id', $quest->id)->first();
    @endphp

    <style>
        .showborder {
            border: 3px solid #1a202c;
        }
    </style>

    <div class="py-12 bg-cover bg-center">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            {{-- Display success message --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                    <p class="m-0">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6 showborder">

                <h1 class="text-4xl font-extrabold mb-4 text-seance-800">{{ $quest->title }}</h1>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                    <div class="md:col-span-3 space-y-4 quest_body">
                        <div class="bg-white p-4 rounded-md shadow-inner">
                            {!! $quest->intro_text !!}
                            @if (!$questLog || Auth::user()->hasRole('manager'))
                                {!!$quest->accept_text !!}
                            @endif
                            @if ($questLog && $questLog->status == 'Accepted' || Auth::user()->hasRole('manager'))
                                {!! $quest->directions_text !!}
                            @endif
                            @if ($questLog && $questLog->status == 'Completed' || Auth::user()->hasRole('manager'))
                                {!! $quest->complete_text !!}
                            @endif
                        </div>
                    </div>

                    <div class="md:col-span-2 space-y-4 quest_body showborder">
                        <div class="bg-white p-4 rounded-md shadow-inner showborder">
                            <p class="text-lg font-semibold text-seance-800">Level: {{ $quest->min_level }}</p>
                            <p class="text-lg font-semibold text-seance-800">XP Award: {{ $quest->xp }}</p>

                            {{-- if bonus_xp is not null, display the bonus_xp--}}
                            @if ($quest->bonus_xp_text)
                                <p><span class="text-lg font-semibold text-seance-800">Bonus XP:</span>
                                    {{ strip_tags($quest->bonus_xp_text) }}</p>
                            @endif
                        </div>
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

            <div class="flex justify-end mt-8 showborder">
                @if (Auth::user()->hasRole('manager'))
                    <a href="{{ route('quests.edit', $quest->id) }}"
                       class="mt-2 px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">Edit
                        Quest</a>
                @endif

                @if (Auth::user()->hasRole('hero') || Auth::user()->hasRole('manager'))

                    @if ($questLog && $questLog->status === 'Accepted')
                        @if($quest->id == 1)
                            <a href="{{ route('profile.hero-registration') }}"
                               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">
                                Hero Registration
                            </a>
                        @else
                            <a href="{{ route('quest-log.complete-form', $questLog) }}"
                               class="mt-2 px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">
                                Complete Quest
                            </a>
                        @endif
                    @elseif($questLog && $questLog->status === 'Completed')
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

    {{ dump($questLog) }}
    {{ dump($quest) }}

</x-app-layout>

