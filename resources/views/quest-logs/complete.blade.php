<x-app-layout>
	<x-slot name="header">
		{{ __('Complete Quest: ') }} {{ $questLog->quest->title }}
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			@if ($errors->any())
				<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">
				<form action="{{ route('quest-log.complete', $questLog) }}" enctype="multipart/form-data" method="POST">
					@csrf

					<div class="mb-5">
						<h2>Congratulations on completing your quest!</h2>
						<p>Thank you for embarking on this quest, brave hero!
							Before you complete your journey, we'd love to know how long it took you to accomplish this task.
							This information helps us to plan future quests and rewards.</p>
					</div>

					<div class="mt-4">
						<div class="flex space-x-3">
							<div>
								<x-input-label for="hours" :value="__('Hours')"/>
								<x-text-input id="hours" type="number" class="block mt-1 w-full" name="hours" :value="old('hours', floor($questLog->minutes / 60))" autofocus autocomplete="hours"/>
								<x-input-error :messages="$errors->get('hours')" class="error-message"/>
							</div>
							<div>
								<x-input-label for="minutes" :value="__('Minutes')"/>
								<x-text-input id="minutes" type="number" class="block mt-1 w-full" name="minutes" :value="old('minutes', $questLog->minutes % 60)" autocomplete="minutes"/>
								<x-input-error :messages="$errors->get('minutes')" class="error-message"/>
							</div>
						</div>
					</div>

					<div class="mt-4">
						{!! $questLog->quest->feedback_text !!}
					</div>

					@if($questLog->quest->feedback_type != 'Hide')
						<div class="mt-4">
							@php
								if(str_contains($questLog->quest->feedback_type, 'HTML')) {
								   $tiny_mce_class = 'tinymce';
								} else if ($questLog->quest->feedback_type !== 'Hide') {
								   $tiny_mce_class = '';
								}
								if(str_contains($questLog->quest->feedback_type, 'Required')) {
									$label_class = 'required-field';
									$reviewRequired = TRUE;
									$reviewLabel = 'This quest will be reviewed.';
								}else{
									$label_class= 'text-gray-700';
									$reviewRequired = FALSE;
									$reviewLabel = 'Please review feedback and consider for bonus xp.';
								}
							@endphp
							<x-input-label for="feedback" class="{{ $label_class }}" :value="__('Feedback')"/>
							<textarea name="feedback" id="feedback" placeholder="" class="{{$tiny_mce_class}} form-textarea w-full" rows="5"></textarea>
							<x-input-error :messages="$errors->get('feedback')" class="error-message"/>
						</div>

						<div id="file-uploads">
							@if(isset($questLog))
								@foreach($questLog->files as $file)
									<div class="file-input my-4">
										<label for="existing_files_{{ $file->id }}" class="block text-sm font-medium text-gray-700">File</label>
										<a href="{{ asset('storage/feedback/' . $questLog->quest->id.'/'.$questLog->id.'/'.$file->filename) }}" target="_blank">{{ $file->filename }}</a>
										<input type="checkbox" name="remove_files[]" value="{{ $file->id }}"> Remove
										<input type="text" name="existing_files[{{ $file->id }}][title]" value="{{ $file->title }}"
											   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
									</div>
								@endforeach
							@endif

							<div class="file-input-new my-4">
								<label for="files[]" class="block text-sm font-medium text-gray-700">File</label>
								<input type="file" name="files[]" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
								<input type="text" name="titles[]" placeholder="Title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
							</div>
						</div>
						<button type="button" id="add-file" class="mt-2 text-seance-600 hover:text-seance-700">Add Another File</button>


						<div class="mt-4">
							<div class="flex items-center">
								<input id="review" type="checkbox" value="1" name="review"
									   {{--									   @checked(old('review', $questLog->review))--}}
									   {{--									   @disabled(old('review', $questLog->review))--}}
									   @checked($reviewRequired)
									   @disabled($reviewRequired)
									   class="disabled:opacity-25 rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"/>

								<x-input-label for="review" class="ml-2 " :value="$reviewLabel"/>
							</div>
							<x-input-error :messages="$errors->get('review')" class="error-message"/>
						</div>

					@endif

					<div class="flex items-center justify-end mt-4">
						<x-primary-button>
							{{ __('Complete Quest') }}
						</x-primary-button>
						<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
					</div>
				</form>
				<script>
					const addFileButton = document.getElementById('add-file');
					const fileUploads = document.getElementById('file-uploads');

					addFileButton.addEventListener('click', () => {
						const newFileInput = document.querySelector('.file-input-new').cloneNode(true);
						newFileInput.querySelector('input[type="file"]').value = ''; // Clear the file input
						newFileInput.querySelector('input[type="text"]').value = ''; // Clear the title input
						fileUploads.appendChild(newFileInput);
					});
				</script>
			</div>
		</div>
	</div>

</x-app-layout>