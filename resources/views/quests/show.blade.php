<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Details') }}: {{$quest->title}}
	</x-slot>
	@php
		$user = Auth::user();
		$questLog = $user->questLogs()->where('quest_id', $quest->id)->first() ?? NULL;
		$userLevel = $user->level;
		$questLevel = $quest->min_level;
		$isEditor = ($user->hasRole('manager') || $user->hasRole('admin'));
	@endphp

	<div class="py-6 bg-cover bg-center"> {{-- BODY_A: BEGIN --}}
		<div class="max-w-7xl mx-auto px-2 lg:px-8"> {{-- BODY_B: BEGIN --}}

			{{-- Display success message --}}
			@if (session('success'))
				<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert"><p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6"> {{-- PAGE: BEGIN --}}
				<h1 class="text-4xl font-extrabold mb-4 text-seance-800">{{ $quest->title }}</h1>

				<div class="grid grid-cols-1 md:grid-cols-6 gap-4"> {{-- COLUMNS: BEGIN --}}
					<div class="md:col-span-4 space-y-4 dynamic"> {{-- LEFT_COLUMN: BEGIN --}}
						<div class="bg-white p-4 rounded-md shadow-inner"> {{-- QUEST BODY: BEGIN --}}
							{!! $quest->intro_text !!}
							@if (!$questLog || $isEditor)
								{!! $quest->accept_text !!}
							@endif
							@if ($questLog && $questLog->status == 'Accepted' || $isEditor)
								{!! $quest->directions_text !!}
							@endif
							@if ($questLog && $questLog->status == 'Completed' || $isEditor)
								{!! $quest->complete_text !!}
							@endif
						</div> {{-- QUEST BODY: END --}}
					</div> {{-- LEFT_COLUMN: END --}}

					<div class="md:col-span-2 space-y-4"> {{-- RIGHT_COLUMN: BEGIN --}}
						<div class="bg-white p-4 rounded-md shadow-inner text-lg text-seance-800"> {{-- STATS: BEGIN --}}
							<p><span class="font-semibold">Level:</span> {{ $quest->min_level }}</p>
							<p><span class="font-semibold">XP Award:</span> {{ $quest->xp }}</p>
							@if ($quest->bonus_xp_text)
								<p><span class="text-lg font-semibold text-seance-800">Bonus XP:</span> {{ strip_tags($quest->bonus_xp_text) }}</p>
							@endif
							@if(FALSE)
								<p><span class="font-semibold">Category:</span> {{ $quest->category->name }}</p>
							@endif
							@if ($quest->campaign)
								<p><span class="font-semibold">Campaign:</span> {{ $quest->campaign->title }}</p>
							@endif
							@if ($quest->repeatable)
								<p><span class="font-semibold">Repeatable:</span> {{ $quest->repeatable }}</p>
							@endif
						</div> {{-- STATS: END --}}

						<div class="bg-white p-4 rounded-md shadow-inner"> {{-- BUTTONS: BEGIN --}}
							@if(!$questLog && ($userLevel > 0 || $questLevel == 0))
								<form action="{{ route('quests.accept', $quest->id) }}" method="POST">
									@csrf
									<div class="mx-auto">
										<button type="submit" class="tg-button-purple" style="width: 100%">Accept Quest</button>
									</div>
								</form>
							@endif

							@if($isEditor)
								<div class="mx-auto">
									<a href="{{ route('quests.edit', $quest->id) }}" class="tg-button-orange">Edit Quest</a>
								</div>
							@endif

							@if($questLog && $questLog->status == 'Accepted' && $quest->id != 1)
								<div class="mx-auto">
									<a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-green">Complete Quest</a>
								</div>
							@endif

							@if($questLog && $questLog->status == 'Accepted' && $quest->id == 1)
								<div class="mx-auto">
									<a href="{{ route('profile.hero-registration') }}" class="tg-button-green">Complete Hero Registration</a>
								</div>
							@endif

							@if($questLog && $questLog->status == 'Completed')
								<div class="mx-auto">
									<p class="tg-button-gray">Quest Already Completed!</p>
								</div>
							@endif

						</div> {{-- BUTTONS: END --}}
					</div> {{-- RIGHT_COLUMN: END --}}
				</div> {{-- COLUMNS: END --}}
			</div> {{-- PAGE: END --}}
		</div> {{-- BODY_B: END --}}
	</div> {{-- BODY_A: END --}}
</x-app-layout>