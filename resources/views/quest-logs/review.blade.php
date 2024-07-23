@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Review Quest: ') }} {{ $questLog->quest->title }}
	</x-slot>

	<div class="grid grid-cols-1 md:grid-cols-6 gap-4 pb-4">

		<div class="col-span-1 md:col-span-2 space-y-4 md:order-last ">
			<x-hero-profile :user="$questLog->user"/>

			<div class="bg-seance-50 px-3 py-1 rounded-md shadow border border-seance-600">
				<h2 class="stat-header">Quest Log Details</h2>
				<div class="flex pb-2">
					<span class="font-bold w-24">Accepted:</span>
					<span class="flex-1"><x-date-user-time-zone :value="$questLog->accepted_at"/></span>
				</div>
				<div class="flex pb-2">
					<span class="font-bold w-24">Completed:</span>
					<span class="flex-1"><x-date-user-time-zone :value="$questLog->completed_at"/></span>
				</div>
				<div class="flex pb-2">
					<span class="font-bold w-24">Time Spent:</span>
					<span class="flex-1">{{ sprintf('%02d:%02d', floor($questLog->minutes / 60), $questLog->minutes % 60) }}</span>
				</div>

				@if($questLog->reviewed_at)
					<hr class="my-2">
					<div class="flex pb-2">
						<span class="font-bold w-24">Reviewed:</span>
						<span class="flex-1"><x-date-user-time-zone :value="$questLog->reviewed_at"/></span>
					</div>
					<div class="flex pb-2">
						<span class="font-bold w-24">Reviewer:</span>
						<span class="flex-1"><a href="{{ route('profile.show-profile', $questLog->reviewer->id) }}">{{ $questLog->reviewer->name }}</a></span>
					</div>
				@endif

			</div>
		</div>

		<div class="col-span-1 md:col-span-4 space-y-4 md:order-first">
			<div class="main-content pt-0">
				<h2><a href="{{ route('quests.show', $questLog->quest->id) }}">{{ $questLog->quest->title }}</a></h2>
				<h3>Feedback</h3>
				<div class="bg-gray-50 px-2 py-0 rounded-md border border-gray-500 mb-4">
					<x-default-value :escape='FALSE' :value="$questLog->feedback" :default="'<p><em>no feedback provided</em></p>'"/>
				</div>
				<h3>Files</h3>
				<ul>
					@if($questLog->files->count() > 0)
						@foreach($questLog->files as $file)
							<li>
								<a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->title }} – {{$file->filename}}</a>
							</li>
						@endforeach
					@else
						<li><em>no files uploaded</em></li>
					@endif
				</ul>
			</div>
		</div>
	</div>

	<div class="main-content">
		@include('quest-logs.partials.edit-form')
	</div>

</x-app-layout>