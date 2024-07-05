<x-app-layout>
	<x-slot name="header">
		{{ __('Drop Quest Confirmation') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-gray-900">
					<p>Are you sure you want to drop the quest "{{ $questLog->quest->title }}"?</p>

					<p>INSERT OTHER TEXT ABOUT WHAT IT MEANS TO DROP AND REACCEPT A QUEST</p>
					<p></p>

					<form action="{{ route('quest-log.drop', $questLog) }}" method="POST">
						@csrf
						<button type="submit" class="tg-button-green">
							Yes, Drop Quest
						</button>
					</form>
					<a href="{{ route('quests.index') }}" class="tg-button-orange">Cancel</a>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
