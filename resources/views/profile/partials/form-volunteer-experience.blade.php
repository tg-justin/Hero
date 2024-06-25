<h2>Past Volunteer Experience with Tabletop Gaymers</h2>

<p>If you've volunteered for Tabletop Gaymers in the past, tell us about it! We'll review your info, and it might
	give you bonus XP!<br>
	<strong class="text-red">Please leave the Past Volunteer Experience field blank if you have not volunteered for TG before.</strong></p>

<div>
	<x-input-label for="past_volunteer_experience" :value="__('Past Volunteer Experience')"/>
	<textarea id="past_volunteer_experience" name="past_volunteer_experience"
			  class="tinymce mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('past_volunteer_experience', $hero->past_volunteer_experience) }}</textarea>
	<x-input-error class="mt-2" :messages="$errors->get('past_volunteer_experience')"/>
</div>