<x-app-layout>
	<x-slot name="header">
		{{ __('Drop Quest Confirmation') }}
	</x-slot>

	<div class="main-content">
		<h2 class="text-red-600">DROP QUEST: {{ $questLog->quest->title }}</h2>
		<p>Are you sure you want to drop this quest?</p>

		<p>Some quests, like those automatically assigned, cannot be re-accepted after they've been dropped. (But most quests can be accepted again later.)</p>

		<form action="{{ route('quest-log.drop', $questLog) }}" method="POST">
			@csrf
			<div class="flex justify-between items-center">
				<x-primary-button class="bg-red-600">DROP QUEST</x-primary-button>
				<div class="w-auto">
					<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
				</div>
			</div>
		</form>
	</div>
</x-app-layout>