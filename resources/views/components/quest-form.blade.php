<form method="POST" action="{{ $quest ? route('quests.update', $quest->id) : route('quests.store') }}">
	@csrf
	@if($quest)
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
				<label for="accept_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Accept</strong> (shown before they accept)</label>
				<textarea id="accept_text" name="accept_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('accept_text', $quest->accept_text ?? '') !!}</textarea>
				@error('accept_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="directions_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Directions</strong> (shown after they accept)</label>
				<textarea id="directions_text" name="directions_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('directions_text', $quest->directions_text ?? '') !!}</textarea>
				@error('directions_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

			<div>
				<label for="complete_text" class="block text-lg pl-1 pt-0 font-medium text-gray-700"><strong>Complete Text</strong> (shown after they complete)</label>
				<textarea id="complete_text" name="complete_text" class="tinymce-full mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('complete_text', $quest->complete_text ?? '') !!}</textarea>
				@error('complete_text')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
			</div>

		</div>

		<div class="md:col-span-2 space-y-4">

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

			{{--
			<div>
				<label for="campaign_id" class="block text-lg pt-5 font-medium text-gray-700">Campaign</label>
				<select name="campaign_id" id="campaign_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
					<option value="">Select Campaign (if applicable)</option>
					@foreach ($campaigns as $campaign)
						<option value="{{ $campaign->id }}" @if ($campaign->id == old('campaign_id', $quest->campaign_id ?? '')) selected @endif>{{ $campaign->title }}</option>
					@endforeach
				</select>
			</div>
			--}}

			{{--
			<div>
				<label for="repeatable" class="block text-lg pt-5 font-medium text-gray-700">Repeatable</label>
				<input type="number" name="repeatable" id="repeatable" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
					   min="0"
					   value="{{ old('repeatable', $quest->repeatable ?? 0) }}">
				@error('repeatable')
				<p class="mt-1 text-sm text-red">{{ $message }}</p>
				@enderror
				<small class="text-gray-500">How many times can this quest be repeated? (0 for non-repeatable)</small>
			</div>
			 --}}

			<div class="mx-auto">
				<button type="submit" class="tg-button-green" style="width: 100%">{{ $submitButtonText }}</button>
			</div>

		</div>
	</div>
</form>
