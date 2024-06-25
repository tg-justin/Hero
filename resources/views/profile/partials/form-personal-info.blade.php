<h2>Personal Information</h2>

<p>This information is only available to you, system admins, and quest managers who are vetted by Tabletop Gaymers.
	This information will only be used to contact you about your quests and other hero-related information. If you really
	don't want us to have your first or last name, please use pseudonyms as these fields are required.
	<strong>We will not share this information without your permission.</strong></p>

{{-- First Name Field --}}
<div>
	<x-input-label for="first_name" class="text-red" :value="__('First/Given Name (required 1-100 characters)')"/>
	<x-text-input id="first_name" name="first_name" type="text" class="block mt-1 w-full max-w-md" :value="old('first_name', $hero->first_name)" maxlength="100" autocomplete="first_name" autofocus/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('first_name')"/>
</div>

{{-- Last Name Field --}}
<div>
	<x-input-label for="last_name" class="text-red" :value="__('Last/Family Name (required 1-100 characters)')"/>
	<x-text-input id="last_name" name="last_name" type="text" class="block mt-1 w-full max-w-md" :value="old('last_name', $hero->last_name)" maxlength="100" autocomplete="last_name"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('last_name')"/>
</div>

{{-- Pronouns Field --}}
<div>
	<x-input-label for="pronouns" :value="__('Pronouns (optional, up to 20 characters)')"/>
	<x-text-input id="pronouns" name="pronouns" type="text" class="block mt-1 w-full max-w-xs" :value="old('pronouns', $hero->pronouns)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('pronouns')"/>
</div>

{{-- Phone Number Field --}}
<div>
	<x-input-label for="phone_number" :value="__('Phone Number')"/>
	<x-text-input id="phone_number" name="phone_number" type="tel" class="block mt-1 w-full max-w-xs" :value="old('phone_number', $hero->phone_number)"/>
	<x-input-error class="mt-2 text-red" :messages="$errors->get('phone_number')"/>
</div>

{{-- Time Zone Selection --}}
<div>
	<x-input-label for="timezone" class="text-red" :value="__('Time Zone')"/>
	<select id="timezone" name="timezone" class="block mt-1 w-full max-w-xs">
		@foreach ($timezones as $timezone)
			<option value="{{ $timezone }}" @if (old('timezone', $hero->timezone) == $timezone) selected @endif>{{ $timezone }}</option>
		@endforeach
	</select>
</div>