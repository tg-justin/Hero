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
							   $tiny_mce_class = 'tinymce-basic';
							}

							if(str_contains($questLog->quest->feedback_type, 'Required')) {
							   $label_class = 'text-red';
							}else{
							   $label_class= 'text-gray-700';
							}
						@endphp
						<div class="mb-4">
							<x-input-label for="feedback" class="{{ $label_class }}" :value="__('Feedback')" />
							<textarea name="feedback" id="feedback" placeholder="" class="{{$tiny_mce_class}} form-textarea w-full" rows="5" ></textarea>
							<x-input-error :messages="$errors->get('feedback')" class="mt-2 text-red" />
						</div>
					@endif

					<div class="mt-4">
						<x-input-label for="minutes" class="text-red" :value="__('Minutes')" />
						<x-text-input id="minutes" type="number" class="block mt-1 w-full" name="minutes" :value="old('minutes', $questLog->minutes)" required autofocus autocomplete="minutes" />
						<x-input-error :messages="$errors->get('minutes')" class="mt-2 text-red" />
					</div>

					<div class="mt-4">
						<div class="flex items-center">
							<input id="review" type="checkbox" value="1" name="review"
								   @checked(old('review', $questLog->review))
								   @disabled(old('review', $questLog->review))
								class="disabled:opacity-25 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
							/>

							<x-input-label for="review" class="text-red ml-2 " :value="__('Review')" /><br/>
							<small class="ml-2">@if($questLog->review) This quest will be reviewed. @else Please review feedback and consider for bonus xp. @endif</small>
						</div>

						<x-input-error :messages="$errors->get('review')" class="mt-2 text-red" />

					</div>


					<div class="flex items-center justify-end mt-4">
						<x-primary-button>
							{{ __('Complete Quest') }}
						</x-primary-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>