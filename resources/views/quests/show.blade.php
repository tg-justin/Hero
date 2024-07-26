<x-app-layout>
	<x-slot name="header">
		{{ __('Quest Info') }}<span class="hidden md:inline">: {{$quest->title}}</span>
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

	<div class="main-content">
		<h1>{{ $quest->title }}</h1>

		<div class="content-split">
			<div class="content-primary md:order-last">

				<div class="bg-white px-3 py-1 rounded-md shadow border border-seance-600">
					<h2 class="stat-header">Quest Details</h2>

					<div class="flex pb-2">
						<span class="font-bold w-24">Level:</span>
						<span class="flex-1">{{ $quest->min_level }}</span>
					</div>

					@if ($questCompleted || $questAccepted)
						<div class="flex pb-2">
							<span class="font-bold w-24">Accepted:</span>
							<span class="flex-1"><x-date-user-time-zone :value="$questLog->accepted_at"/></span>
						</div>
					@endif

					@if($questCompleted)
						<div class="flex pb-2">
							<span class="font-bold w-24">Completed:</span>
							<span class="flex-1"><x-date-user-time-zone :value="$questLog->completed_at"/></span>
						</div>

						<div class="flex pb-2">
							<span class="font-bold w-24">XP Awarded:</span>
							<span class="flex-1">
								{{ $questLog->xp_awarded + $questLog->xp_bonus }}
								@if($questLog->xp_bonus > 0)
									({{ $questLog->xp_awarded }} + {{ $questLog->xp_bonus }} bonus)
								@endif
							</span>
						</div>

					@else
						<div class="flex pb-2">
							<span class="font-bold w-24">XP Award:</span>
							<span class="flex-1">{{ $quest->xp }}</span>
						</div>

						@if ($quest->bonus_xp_text)
							<div class="pb-2">
								<span class="font-bold">Bonus XP:</span>
								<span>{{ strip_tags($quest->bonus_xp_text) }}</span>
							</div>
						@endif
					@endif

					@if(FALSE)
						<div class="flex pb-2">
							<span class="font-bold w-24">Category:</span>
							<span class="flex-1">{{ $quest->category->name }}</span>
						</div>
					@endif

					@if ($quest->campaign)
						<div class="flex pb-2">
							<span class="font-bold w-24">Campaign:</span>
							<span class="flex-1">{{ $quest->campaign->title }}</span>
						</div>
					@endif

					@if ($quest->repeatable)
						<div class="flex pb-2">
							<span class="font-bold w-24">Repeatable:</span>
							<span class="flex-1">{{ $quest->repeatable }}</span>
						</div>
					@endif

					@if($isEditor && $quest->notify_email != NULL)
						<div class="flex pb-2">
							<span class="font-bold w-24">Notify:</span>
							<span class="flex-1">{{ $quest->notify_email }}</span>
						</div>
					@endif

					@if($quest->files->count() > 0)
						<h2 class="stat-header mb-0">Attachments</h2>
						<ul class="mt-0">
							@foreach($quest->files as $file)
								@php
									$extension = strtoupper(pathinfo($file->path, PATHINFO_EXTENSION));
								@endphp
								<li>
									<a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->title }} ({{ $extension }})</a>
								</li>
							@endforeach
						</ul>
					@endif
				</div> {{-- STATS: END --}}

				<div class="p-0"> {{-- BUTTONS: BEGIN --}}

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
							<a href="{{ route('quests.quest-logs', $quest) }}" class="tg-button-orange">View Quest Logs</a>
						</div>
						<div class="mx-auto">
							<a href="{{ route('quests.confirm-delete', $quest->id) }}" class="tg-button-red">Delete Quest</a>
						</div>
					@endif

					@if($questAccepted && $quest->id != 1)
						<div class="mx-auto">
							<a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-green">Complete Quest</a>
						</div>
						<div class="mx-auto">
							<a href="{{ route('quest-log.drop-confirm', $questLog) }}" class="tg-button-gray">Drop Quest</a>
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
						<div class="text-2xl font-bold text-seance-900 bg-gray-300 py-1 my-2 text-center">Quest Info</div>
						{!! $quest->intro_text !!}
						<hr class="my-4">
						{!! $quest->accept_text !!}
						<hr class="my-4">
						{!! $quest->directions_text !!}

						{{--						http://hero.test/quest-log/39/complete --}}
						<div class="text-2xl font-bold text-seance-900 bg-gray-300 py-1 my-2 text-center">Your Submission</div>
						<h3>Feedback</h3>
						<div class="bg-gray-50 px-2 py-0 rounded-md border border-gray-500 mb-4 ml-8">
							<x-default-value :escape='FALSE' :value="$questLog->feedback" :default="'<p><em>no feedback provided</em></p>'"/>
						</div>

						<h3>File Uploads</h3>
						<ul class="mt-0">
							@if($questLog->files->count() > 0)
								@foreach($questLog->files as $file)
									@php
										$extension = strtoupper(pathinfo($file->path, PATHINFO_EXTENSION));
									@endphp
									<li>
										<a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->title }} ({{ $extension }})</a>
									</li>
								@endforeach
							@else
								<li><em>no files uploaded</em></li>
							@endif
						</ul>

						<div class="mx-auto">
							<a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-green">Complete Quest</a>
						</div>


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
				</div>
			</div>

		</div>
	</div>
</x-app-layout>