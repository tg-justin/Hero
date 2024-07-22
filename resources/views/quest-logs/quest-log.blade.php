<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Log') }}
	</x-slot>

	<div class="main-outer">
		<div class="main-inner">

			{{-- Display success message --}}
			@if (session('success'))
				<div class="alert-success" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			<div class="overflow-hidden rounded-lg">
				<x-hero-profile :user="$user"/>

				<div class="main-content">

					@if ($acceptedQuests->count() == 0 && $completedQuests->count() == 0)
						<p class="text-center text-lg font-semibold">Visit the <a href="/quests">Quest Board</a> to get started!</p>
					@else
						@if ($acceptedQuests->count() > 0)
							<h3 class="text-lg font-semibold mb-4">Accepted Quests</h3>
							<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
								@foreach ($acceptedQuests as $questLog)
									<x-quest-card :quest="$questLog->quest" :questLog="$questLog"/>
								@endforeach
							</div>
						@endif


						@if ($completedQuests->count() > 0)
							<h3 class="text-lg font-semibold mt-8 mb-4">Completed Quests</h3>
							<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
								@foreach ($completedQuests as $questLog)
									<x-quest-card :quest="$questLog->quest" :questLog="$questLog"/>
								@endforeach
							</div>
						@endif
					@endif

				</div>

			</div>
		</div>
	</div>
</x-app-layout>