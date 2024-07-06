@php
	$viewer = auth()->user();
	$isEditor = $viewer->hasRole('manager') || $viewer->hasRole('admin');
@endphp
<div class="bg-gradient-to-br from-seance-200 to-seance-300 p-2 rounded-lg flex items-center mb-5 border border-seance-500">
	<div class="flex flex-col items-center mr-4">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-16 h-16 rounded-full bg-seance-700">
			<text x="50%" y="55%" dominant-baseline="central" text-anchor="middle" font-size="12" fill="white">{{ substr($user->name, 0, 1) }}</text>
		</svg>
		<span class="text-xs text-gray-600 mt-2">Level {{ $user->level }} <br/> {{ $user->levelName }}</span>
	</div>
	<div>
		<div class="mb-2">
			<span class="text-2xl font-semibold text-seance-800 mb-0 pb-0">{{ $user->name }}</span>
			@if($isEditor)
				<br><span class="text-base text-seance-700 mt-0 pt-0">
					(<a href="{{ route('profile.show-profile', ['heroId' => $user->id]) }}">{{ $user->first_name }} {{ $user->last_name }}</a>)
				</span>
			@endif
		</div>
		<div class="flex items-center mb-2">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
			</svg>
			<span class="text-sm text-seance-700 ml-1">{{ $user->completedQuests()->count() }} Quests Completed</span>
		</div>
		<div class="flex items-center mb-2">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 24 24" fill="none"
				 stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
				<polygon points="12 2 19 21 12 17 5 21 12 2"></polygon>
			</svg>
			<span class="text-sm text-seance-700 ml-1">{{ $user->totalxp() }} Total xp</span>
		</div>

		<div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
			<div class="bg-seance-600 h-2.5 rounded-full" style="width: {{ $user->xpPercentage() }}%;"></div>
		</div>
	</div>
	<div class="flex flex-row space-x-4 ml-5">
		@foreach ($user->badges as $badge)
			<img src="{{ asset($badge->image_path) }}" alt="{{ $badge->name }}" class="h-20 w-20">
		@endforeach
	</div>

</div>