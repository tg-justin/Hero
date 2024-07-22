<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Details') }}: {{$quest->title}}
	</x-slot>
	@php
		$user = auth()->user();
		$questLog = $user->questLogs()->where('quest_id', $quest->id)->first() ?? NULL;
		$userLevel = $user->level;
		$questLevel = $quest->min_level;
		$isEditor = ($user->hasRole('manager') || $user->hasRole('admin'));
		$questAccepted = ($questLog && $questLog->status == 'Accepted');
		$questCompleted = ($questLog && $questLog->status == 'Completed');
		$questDropped = ($questLog && $questLog->status == 'Dropped');
	@endphp

	<div class="main-outer">
		<div class="main-inner">

			{{-- Display error message --}}
			@if(session('error'))
				<div class="alert-error" role="alert">
					<p class="mt-0">{{ session('error') }}</p>
				</div>
			@endif

			{{-- Display success message --}}
			@if (session('success'))
				<div class="alert-success" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			<div class="main-content"> {{-- PAGE: BEGIN --}}
				<h1>{{ $quest->title }}</h1>

				<div class="content-split"> {{-- COLUMNS: BEGIN --}}

					<div class="content-primary md:order-last"> {{-- RIGHT_COLUMN: BEGIN --}}
						<div class="bg-white p-4 rounded-md shadow-inner text-lg text-seance-800"> {{-- STATS: BEGIN --}}
							<p><span class="font-semibold">Quest Level:</span> {{ $quest->min_level }}</p>
							@if ($questCompleted || $questAccepted)
								<p><span class="font-semibold">Accepted:</span>
									<x-date-user-time-zone :value="$questLog->accepted_at"/>
								</p>
							@endif
							@if($questCompleted)
								<p><span class="font-semibold">Completed:</span>
									<x-date-user-time-zone :value="$questLog->completed_at"/>
								</p>
								<p><span class="font-semibold">XP Award:</span> {{ $questLog->xp_awarded }}</p>
								@if($questLog->xp_bonus > 0)
									<p><span class="font-semibold">XP Bonus:</span> {{ $questLog->xp_bonus }}</p>
									<p><span class="font-semibold">XP Total:</span> {{ $questLog->xp_awarded + $questLog->xp_bonus }}</p>
								@endif
							@else
								<p><span class="font-semibold">XP Award:</span> {{ $quest->xp }}</p>
								@if ($quest->bonus_xp_text)
									<p><span class="text-lg font-semibold text-seance-800">Bonus XP:</span> {{ strip_tags($quest->bonus_xp_text) }}</p>
								@endif
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
							@if($isEditor)
								<p><span class="font-semibold">Email Notification:</span> {{ $quest->notify_email }}</p>
							@endif
							@if($quest->files->count() > 0)
								<div class="mt-4">
									<h2 class="stat-header">Attachments</h2>
									<ul>
										@foreach($quest->files as $file)
											<li>
												<a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->title }}</a>
											</li>
										@endforeach
									</ul>
								</div>
							@endif

						</div> {{-- STATS: END --}}

						<div class="bg-white p-4 rounded-md shadow-inner"> {{-- BUTTONS: BEGIN --}}
							{{--							@php dump($questLog); @endphp--}}
							@if((!$questLog && ($userLevel > 0 || $questLevel == 0)) || $questDropped)
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
								<div class="mx-auto">
									<a href="{{ route('quests.duplicate', $quest) }}" class="tg-button-orange">Duplicate Quest</a>
								</div>
								<div class="mx-auto">
									<a href="{{ route('quests.confirm-delete', $quest->id) }}" class="tg-button-orange">Delete Quest</a>
								</div>

							@endif

							@if($questAccepted && $quest->id != 1)
								<div class="mx-auto">
									<a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-green">Complete Quest</a>
								</div>
								<div class="mx-auto">
									<a href="{{ route('quest-log.drop-confirm', $questLog) }}" class="tg-button-orange">Drop Quest</a>
								</div>
							@endif

							@if($questAccepted && $quest->id == 1)
								<div class="mx-auto">
									<a href="{{ route('profile.hero-registration') }}" class="tg-button-green">Complete Hero Registration</a>
								</div>
							@endif

							@if($questCompleted)
								<div class="mx-auto">
									<p class="tg-button-gray">Quest Already Completed!</p>
								</div>
							@endif

						</div> {{-- BUTTONS: END --}}
					</div> {{-- RIGHT_COLUMN: END --}}

					<div class="content-secondary md:order-first"> {{-- LEFT_COLUMN: BEGIN --}}
						<div class="bg-white p-4 rounded-md shadow-inner"> {{-- QUEST BODY: BEGIN --}}
							@if ($questCompleted)
								{!! $quest->complete_text !!}
								<br>
								<p class="text-2xl font-bold text-gray-500 border-t-4 border-b-4 py-1">Quest Review</p>
								{!! $quest->intro_text !!}
								<hr class="my-4">
								{!! $quest->accept_text !!}
								<hr class="my-4">
								{!! $quest->directions_text !!}
								@if($questLog->feedback)
									<br>
									<p class="text-2xl font-bold text-gray-500 border-t-4 border-b-4 py-1">Your Feedback</p>
									<x-default-value :escape="FALSE" :value="$questLog->feedback"/>
								@endif
							@else
								{!! $quest->intro_text !!}
								@if (!$questLog || $isEditor)
									{!! $quest->accept_text !!}
								@endif
								@if ($questAccepted || $isEditor)
									{!! $quest->directions_text !!}
								@endif
								@if ($questCompleted || $isEditor)
									{!! $quest->complete_text !!}
								@endif
							@endif
						</div> {{-- QUEST BODY: END --}}
					</div> {{-- LEFT_COLUMN: END --}}

				</div> {{-- COLUMNS: END --}}
			</div> {{-- PAGE: END --}}
		</div> {{-- BODY_B: END --}}
	</div> {{-- BODY_A: END --}}
</x-app-layout>