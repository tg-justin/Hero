<div class="block rounded-lg shadow-lg p-4 bg-gradient-to-br from-seance-100 to-seance-200">
	<div class="flex items-center justify-between mb-2">
		<h4 class="text-lg font-semibold text-seance-800">{{ $quest->title }}</h4>
		<span class="text-xs text-white px-2 py-1 rounded-full {{ $questLog->statusColor }}">{{ $questLog->status }}</span>
	</div>
	{{--    <p class="text-sm text-seance-700 mb-2">{!! Str::limit($quest->directions_text, 75) !!}</p>--}}
	<div class="flex items-center space-x-2">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
			<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
			<path fill-rule="evenodd" d="M.458 10C1.736 5.943 5.522 3 10 3s8.264 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.736 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
		</svg>
		<span class="text-sm text-seance-700">{{ $quest->xp }} xp</span>
	</div>

	<div class="mt-4 flex justify-between">
		<a href="{{ route('quests.show', $quest->id) }}" class="px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">
			View Quest
		</a>

		{{--        @if (!is_null($questLog) && $questLog->status === 'accepted')--}}
		{{--            @if($quest->id == 1)--}}
		{{--                <a href="{{ route('profile.hero-registration') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">--}}
		{{--                    Hero Registration--}}
		{{--                </a>--}}
		{{--            @else--}}
		{{--                <a href="{{ route('quest-log.complete-form', $questLog) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md">--}}
		{{--                    Complete Quest--}}
		{{--                </a>--}}
		{{--            @endif--}}
		{{--        @endif--}}
	</div>
</div>
