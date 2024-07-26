<h2>Public Information</h2>

<p>This information is <strong>visible to other Heroes and may be included in our promotional material</strong>.
	We reserve the right to modify your information for appropriateness. Do not share your exact location, you
	may leave it blank or enter something regional like "Chicago IL" or "Florida".</p>

<div class="space-y-6">
	<div>
		<label for="name" class="field-label field-required">Hero/Display Name</label>
		(required, 3-50 characters)
		<x-text-input id="name" name="name" type="text" class="block mt-1 w-full max-w-md" :value="old('name', $hero->name)" maxlength="50" autofocus/>
		<x-input-error class="error-message" :messages="$errors->get('name')"/>
	</div>

	<div>
		<label for="location" class="field-label">Your Location</label>
		(optional, up to 50 characters)
		<x-text-input id="location" name="location" type="text" class="block mt-1 w-full max-w-md" :value="old('location', $hero->location)" maxlength="50" autocomplete="location"/>
		<x-input-error class="error-message" :messages="$errors->get('location')"/>
	</div>

	<div>
		<label for="public_profile" class="field-label">Your Publicly Visible Profile</label>
		(optional)
		<textarea id="public_profile" name="public_profile"
				  class="tinymce mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
		>{{ old('public_profile', $hero->public_profile) }}</textarea>
		<x-input-error class="error-message" :messages="$errors->get('public_profile')"/>
	</div>
</div>