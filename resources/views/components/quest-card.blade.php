<div class="block rounded-lg shadow-lg p-4 bg-gradient-to-br from-seance-100 to-seance-200">
	<div class="flex items-center justify-between mb-2">
		<h4 class="text-lg font-semibold text-seance-800">{{ $quest->title }}</h4>
	</div>

	<div class="flex items-center space-x-2">
		<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
			<polygon points="12 2 19 21 12 17 5 21 12 2"></polygon>
		</svg>

		<span class="text-sm text-seance-700">{{ $quest->xp }} xp</span>
	</div>

	<div class="mt-4 flex justify-between">
		<a href="{{ route('quests.show', $quest->id) }}" class="px-4 py-2 bg-seance-600 hover:bg-seance-700 text-white rounded-md">
			View Quest
		</a>
	</div>
</div>
