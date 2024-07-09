<form method="POST" enctype="multipart/form-data" action="{{ ($quest && !is_null($quest->id))  ? route('quests.update', $quest->id) : route('quests.store') }}">
	@csrf
	@if($quest && !is_null($quest->id))
		@method('PUT')
	@endif
	<div>
		<label for="title" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Title</strong></label>
		<input type="text" name="title" id="title" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-4xl font-extrabold text-seance-800"
			   value="{{ old('title', $quest->title ?? '') }}">
		@error('title')
		<p class="mt-1 text-sm text-red">{{ $message }}</p>
		@enderror
	</div>

	<div class="grid grid-cols-1 md:grid-cols-6 gap-4 pt-4">
		<div class="md:col-span-4 space-y-4">

			<div>
				<label for="intro_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Introduction</strong> (always shown)</label>
				<textarea id="intro_text" name="intro_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('intro_text', $quest->intro_text ?? '') !!}</textarea>
				@error('intro_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="accept_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Accept</strong> (optional, shown <strong>before</strong> they accept)</label>
				<textarea id="accept_text" name="accept_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('accept_text', $quest->accept_text ?? '') !!}</textarea>
				@error('accept_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="directions_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Directions</strong> (shown <strong>after</strong> they accept)</label>
				<textarea id="directions_text" name="directions_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('directions_text', $quest->directions_text ?? '') !!}</textarea>
				@error('directions_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="complete_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Complete Text</strong> (optional, shown after they complete)</label>
				<textarea id="complete_text" name="complete_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('complete_text', $quest->complete_text ?? '') !!}</textarea>
				@error('complete_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="feedback_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Feedback Text</strong> (optional, shown on the complete quest screen)</label>
				<textarea id="feedback_text" name="feedback_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('feedback_text', $quest->feedback_text ?? '') !!}</textarea>
				@error('feedback_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="feedback_type" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Feedback Type</strong>
					(hide – don't allow any feedback,
					required - require feedback to complete)
				</label>
				<select name="feedback_type" id="feedback_type" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					@foreach ($feedback_types as $type)
						<option value="{{ $type }}" {{ old('feedback_type', $quest->feedback_type ?? NULL) == $type ? "selected" : "" }}>
							{{ $type }}
						</option>

					@endforeach

					@error('feedback_type')
					<p class="mt-1 text-sm text-red">{{ $message }}</p>
					@enderror
				</select>
			</div>
		</div>

		<div class="md:col-span-2 space-y-4"> {{-- Right side of the form --}}
			<div>
				<label for="min_level" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Level</strong></label>
				<input type="number" name="min_level" id="min_level" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0"
					   value="{{ old('min_level', $quest->min_level ?? '') }}">
				@error('min_level')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="xp" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">XP</strong> (automatically awarded)</label>
				<input type="number" name="xp" id="xp" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0"
					   value="{{ old('xp', $quest->xp ?? '') }}">
				@error('xp')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="bonus_xp_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Bonus XP Instructions</strong></label>
				<textarea id="bonus_xp_text" name="bonus_xp_text" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
						  rows="3">{{ old('bonus_xp_text', $quest->bonus_xp_text ?? '') }}</textarea>
				@error('bonus_xp_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="category_id" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong class="text-red">Category</strong></label>
				<select name="category_id" id="category_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					<option value="">-- Select --</option>
					@foreach ($categories as $category)
						<option value="{{ $category->id }}" @if ($category->id != old('category_id', $quest->category_id ?? '')) selected @endif>{{ $category->name }}</option>
					@endforeach
					@error('category_id')
					<p class="mt-1 text-sm text-red">{{ $message }}</p>
					@enderror
				</select>
			</div>

			<div>
				<label for="start_date" class="block text-lg pl-1 pt-0 font-medium text-gray-700">Start Date</label>
				<input type="date" name="start_date" id="start_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					   value="{{ old('start_date', $quest->start_date ?? '') }}">
				@error('start_date')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="expires_date" class="block text-lg pl-1 pt-0 font-medium text-gray-700">Expires Date</label>
				<input type="date" name="expires_date" id="expires_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					   value="{{ old('expires_date', $quest->expires_date ?? '') }}">
				@error('expires_date')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<div class="flex items-center">
					<input id="notify_email" type="checkbox" value="1" name="notify_email"
						   @checked(old('notify_email', $quest->notify_email ?? ''))
						   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					/>

					<x-input-label for="notify_email" class="text-red ml-2 " :value="__('Email Notification')"/>
					<br/>
					<small class="ml-2">Receive an email when a hero completes this quest.</small>
				</div>

				<x-input-error :messages="$errors->get('notify_email')" class="mt-2 text-red"/>

			</div>

			<div id="file-uploads">
				@if(isset($quest))
					@foreach($quest->files as $file)
						<div class="file-input my-4">
							<label for="existing_files_{{ $file->id }}" class="block text-sm font-medium text-gray-700">File</label>
							<a href="{{ asset('storage/quests/'.$quest->id.'/'.$file->filename) }}" target="_blank">{{ $file->filename }}</a>
							<input type="checkbox" name="remove_files[]" value="{{ $file->id }}"> Remove
							<input type="text" name="existing_files[{{ $file->id }}][title]" value="{{ $file->title }}" maxlength="30" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm
							border-gray-300 rounded-md">

						</div>
					@endforeach
				@endif

				<div class="file-input-new my-4">
					<label for="files[]" class="block text-sm font-medium text-gray-700">New File</label>
					<input type="file" name="files[]" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
					<input type="text" name="titles[]" placeholder="Title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
				</div>
			</div>
			<button type="button" id="add-file" class="mt-2 text-seance-600 hover:text-seance-700">Add Another File</button>


			<div class="mx-auto">
				<button type="submit" class="tg-button-green" style="width: 100%">{{ $submitButtonText }}</button>
			</div>

		</div>
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