<form method="POST" enctype="multipart/form-data" action="{{ ($quest && !is_null($quest->id))  ? route('quests.update', $quest->id) : route('quests.store') }}">
	@csrf
	@if($quest && !is_null($quest->id))
		@method('PUT')
	@endif

	<div class="mb-2 md:mb-8">
		<label for="title" class="field-label field-required">Title</label>
		<input type="text" name="title" id="title"
			   class="text-3xl font-extrabold text-seance-800
			   			mt-1 p-2 w-full rounded-md border-gray-300 shadow-sm
						focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
			   value="{{ old('title', $quest->title ?? '') }}">
		@error('title')
		<p class="error-message">{{ $message }}</p>
		@enderror
	</div>

	<div class="content-split">
		<div class="content-wide">

			<div>
				<label for="intro_text" class="field-label field-required">Introduction</label>
				(required, always shown)
				<textarea id="intro_text" name="intro_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('intro_text', $quest->intro_text ?? '') !!}</textarea>
				@error('intro_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="accept_text" class="field-label">Accept</label>
				(optional, shown <strong>before</strong> they accept)
				<textarea id="accept_text" name="accept_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('accept_text', $quest->accept_text ?? '') !!}</textarea>
				@error('accept_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="directions_text" class="field-label field-required">Directions</label>
				(required, shown <strong>after</strong> they accept)
				<textarea id="directions_text" name="directions_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('directions_text', $quest->directions_text ?? '') !!}</textarea>
				@error('directions_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="complete_text" class="field-label">Complete Text</label>
				(optional, shown after they complete)
				<textarea id="complete_text" name="complete_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('complete_text', $quest->complete_text ?? '') !!}</textarea>
				@error('complete_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="feedback_text" class="field-label">Feedback Text</label>
				(optional, shown on the complete quest screen)
				<textarea id="feedback_text" name="feedback_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('feedback_text', $quest->feedback_text ?? '') !!}</textarea>
				@error('feedback_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="feedback_type" class="field-label field-required">Feedback Type</label>
				(hide – don't allow any feedback, required - require feedback to complete)
				<select name="feedback_type" id="feedback_type" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					@foreach ($feedback_types as $type)
						<option value="{{ $type }}" {{ old('feedback_type', $quest->feedback_type ?? NULL) == $type ? "selected" : "" }}>
							{{ $type }}
						</option>

					@endforeach

					@error('feedback_type')
					<p class="error-message">{{ $message }}</p>
					@enderror
				</select>
			</div>
		</div>

		<div class="content-narrow">
			<div>
				<label for="min_level" class="field-label field-required">Level</label>
				<input type="number" name="min_level" id="min_level" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0"
					   value="{{ old('min_level', $quest->min_level ?? '') }}">
				@error('min_level')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="xp" class="field-label field-required">XP</label>
				(automatically awarded)
				<input type="number" name="xp" id="xp" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0"
					   value="{{ old('xp', $quest->xp ?? '') }}">
				@error('xp')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="bonus_xp_text" class="field-label">Bonus XP Instructions</label>
				<textarea id="bonus_xp_text" name="bonus_xp_text" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
						  rows="3">{{ old('bonus_xp_text', $quest->bonus_xp_text ?? '') }}</textarea>
				@error('bonus_xp_text')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="category_id" class="field-label field-required">Category</label>
				<select name="category_id" id="category_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					<option value="">-- Select --</option>
					@foreach ($categories as $category)
						<option value="{{ $category->id }}" @if ($category->id == old('category_id', $quest->category_id ?? '')) selected @endif>{{ $category->name }}</option>
					@endforeach
					@error('category_id')
					<p class="error-message">{{ $message }}</p>
					@enderror
				</select>
			</div>

			<div>
				<label for="start_date" class="field-label">Start Date</label>
				<input type="date" name="start_date" id="start_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					   value="{{ old('start_date', $quest->start_date ?? '') }}">
				@error('start_date')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="expires_date" class="field-label">Expires Date</label>
				<input type="date" name="expires_date" id="expires_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					   value="{{ old('expires_date', $quest->expires_date ?? '') }}">
				@error('expires_date')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="notify_email" class="field-label">Email Notifications</label>
				<textarea id="notify_email" name="notify_email" rows="2"
						  placeholder="Enter email addresses separated by commas"
						  class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-sm"
				>{{ old('notify_email', $quest->notify_email ?? '') }}</textarea>
				@error('notify_email')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>

			<div id="file-uploads">
				@if(isset($quest))
					@foreach($quest->files as $file)
						<div class="file-input my-4">
							<label for="existing_files_{{ $file->id }}" class="field-label">File</label>
							<a href="{{ asset('storage/quests/'.$quest->id.'/'.$file->filename) }}" target="_blank">{{ $file->filename }}</a>
							<input type="checkbox" name="remove_files[]" value="{{ $file->id }}"> Remove
							<input type="text" name="existing_files[{{ $file->id }}][title]" value="{{ $file->title }}" maxlength="30"
								   class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
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


			<div>
				<label for="status" class="field-label field-required">Status</label>
				<select name="status" id="status" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					{{-- Determine the value to select. Priority: old input -> existing quest -> default ('Draft') --}}
					@php
						// Safely get the status value, defaulting to 'Draft' if no old input and no quest object
						$selectedStatus = old('status', $quest->status ?? 'Draft');
					@endphp
					<option value="Draft"    @if ($selectedStatus == 'Draft')    selected @endif>Draft</option>
					<option value="Active"   @if ($selectedStatus == 'Active')   selected @endif>Active</option>
					<option value="Archived" @if ($selectedStatus == 'Archived') selected @endif>Archived</option>
				</select>
				{{-- Check for validation errors specifically for the 'status' field --}}
				@error('status')
				<p class="error-message">{{ $message }}</p>
				@enderror
			</div>
			<div class="mx-auto">
				<button type="submit" class="tg-button-green" style="width: 100%">{{ $submitButtonText }}</button>
				<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
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