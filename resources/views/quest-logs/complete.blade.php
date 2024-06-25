<x-app-layout>
	<x-slot name="header">
		{{ __('Complete Quest: ') }} {{ $questLog->quest->title }}
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">
				<div class="mb-5">
					<h2>Congratulations on completing your quest!</h2>
					<p>Thank you for embarking on this quest, brave hero! Before you complete your journey, we'd love to know how long it took you to accomplish this task. This information helps us to plan future quests and rewards. </p>
				</div>

				<form action="{{ route('quest-log.complete', $questLog) }}" method="POST">
					@csrf
					@if($questLog->quest->feedback_type != 'Hide')
						@php
							if(str_contains($questLog->quest->feedback_type, 'HTML')) {
								$tiny_mce_class = 'tinymce-full';
							} else if ($questLog->quest->feedback_type !== 'Hide') {
								$tiny_mce_class = 'tinymce-basic'; // If feedback is hidden don't show the textarea at all
							}
						@endphp
					<div class="mb-4">
							<label for="feedback" class="block text-gray-700 text-sm font-bold mb-2">Feedback:</label>
							<textarea name="feedback" placeholder="" class="{{ $tiny_mce_class }} form-textarea w-full" rows="5" ></textarea>
							@error('feedback')
							<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
							@enderror
						</div>
					@endif
					<div class="mb-4">
						<label for="minutes" class="block text-gray-700 text-sm font-bold mb-2">Minutes:</label>
						<input type="number" name="xp_awarded" id="xp_awarded" class="form-input w-full" value="{{ old('minutes', $questLog->minutes) }}" required>
						@error('minutes')
						<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
						@enderror
					</div>

					<button type="submit" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">
						Complete Quest
					</button>
				</form>

			</div>
		</div>
	</div>
</x-app-layout>