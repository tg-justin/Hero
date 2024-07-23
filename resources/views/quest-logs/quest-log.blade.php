<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Log') }}
	</x-slot>

	<x-hero-profile :user="$user"/>

	<div class="main-content">
		@if ($acceptedQuests->count() == 0 && $completedQuests->count() == 0)
			<p class="text-center text-lg font-semibold">Visit the <a href="/quests">Quest Board</a> to get started!</p>
		@else
			@if ($acceptedQuests->count() > 0)
				<h2 class="mt-0">Accepted Quests</h2>
				<div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
					@foreach ($acceptedQuests as $questLog)
						<x-quest-card :quest="$questLog->quest" :questLog="$questLog"/>
					@endforeach
				</div>
			@endif

			@if ($completedQuests->count() > 0)
				<h2>Completed Quests</h2>
				<div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
					@foreach ($completedQuests as $questLog)
						<x-quest-card :quest="$questLog->quest" :questLog="$questLog"/>
					@endforeach
				</div>
			@endif
		@endif
	</div>
</x-app-layout>