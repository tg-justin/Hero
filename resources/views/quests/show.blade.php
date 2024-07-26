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
					<h2 class="stat-header mt-1">Quest Details</h2>
					<table class="stat-block">
						<tr>
							<th>Level:</th>
							<td>{{ $quest->min_level }}</td>
						</tr>

						@if($questCompleted || $questAccepted)
							<tr>
								<th>Accepted:</th>
								<td>
									<x-date-user-time-zone :value="$questLog->accepted_at"/>
								</td>
							</tr>
						@endif

						@if($questCompleted)
							<tr>
								<th>Completed:</th>
								<td>
									<x-date-user-time-zone :value="$questLog->completed_at"/>
								</td>
							</tr>
							<tr>
								<th>XP Awarded:</th>
								<td>
									{{ $questLog->xp_awarded + $questLog->xp_bonus }}
									@if($questLog->xp_bonus > 0)
										({{ $questLog->xp_awarded }} + {{ $questLog->xp_bonus }} bonus)
									@endif
								</td>
							</tr>
						@else
							<tr>
								<th>XP Award:</th>
								<td>{{ $quest->xp }}</td>
							</tr>
							@if ($quest->bonus_xp_text)
								<tr>
									<th>Bonus XP:</th>
									<td>{{ strip_tags($quest->bonus_xp_text) }}</td>
								</tr>
							@endif
						@endif

						@if(FALSE)
							<tr>
								<th>Category:</th>
								<td>{{ $quest->category->name }}</td>
							</tr>
						@endif

						@if ($quest->campaign)
							<tr>
								<th>Campaign:</th>
								<td>{{ $quest->campaign->title }}</td>
							</tr>
						@endif

						@if ($quest->repeatable)
							<tr>
								<th>Repeatable:</th>
								<td>{{ $quest->repeatable }}</td>
							</tr>
						@endif

						@if($isEditor && $quest->notify_email != NULL)
							<tr>
								<th>Notify:</th>
								<td>
									{{ $quest->notify_email }}
								</td>
							</tr>
						@endif
					</table>

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
						<div class="text-2xl font-bold text-seance-900 bg-gray-300 py-1 my-2 text-center">Quest Complete!</div>
						<x-default-value :escape='FALSE' :value="$quest->complete_text" default="<p>You have completed this quest!</p>"/>

						<div class="flex justify-between items-center">
							<h3>Your Feedback</h3>
							<span><a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-gray">Edit</a></span>
						</div>
						<div class="bg-gray-50 px-2 py-0 rounded-md border border-gray-500 mb-4 ml-8">
							<x-default-value :escape='FALSE' :value="$questLog->feedback" :default="'<p><em>no feedback provided</em></p>'"/>
						</div>



						<div class="flex justify-between items-center">
							<h3>Your Uploads</h3>
							<span><a href="{{ route('quest-log.complete-form', $questLog) }}" class="tg-button-gray">Edit</a></span>
						</div>
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

						@if($questLog->reviewed_at != NULL)
							<div class="flex justify-between items-center">
								<h3>Reviewer Comments</h3>
								@if ($isEditor)
									<span><a href="{{ route('quest-logs.review', $questLog) }}" class="tg-button-gray">Edit</a></span>
								@else
									<span>&nbsp;</span>
								@endif
							</div>
							<div class="bg-gray-50 px-2 py-0 rounded-md border border-gray-500 mb-4 ml-8">
								<x-default-value :escape='FALSE' :value="$questLog->reviewer_message" :default="'<p><em>no comments provided</em></p>'"/>
							</div>
						@endif

						<div class="text-2xl font-bold text-seance-900 bg-gray-300 py-1 my-2 text-center">Quest Info</div>

					@endif  {{-- COMPLETED QUEST DETAILS: END --}}


					{!! $quest->intro_text !!}

					@if (!$questLog || $isEditor || $questCompleted)
						{!! $quest->accept_text !!}
					@endif

					@if ($questAccepted || $isEditor || $questCompleted)
						{!! $quest->directions_text !!}
					@endif

					@if ($questCompleted || $isEditor || $questCompleted)
						{!! $quest->complete_text !!}
					@endif

				</div>
			</div>

		</div>
	</div>
</x-app-layout>