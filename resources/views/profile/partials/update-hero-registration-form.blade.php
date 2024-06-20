<section>
	<header>
		@if(request()->routeIs('profile.hero-registration'))
			<h2 class="text-lg font-medium text-seance-200">
				{{ __('Hero Information') }}
			</h2>
			<p class="mt-2 text-mm text-seance-200">
				After you complete this registration, you will be promoted to a <strong>Level 1 Hero</strong> and
				will be able to view and accept other quests. If you ever need to change this information, you can
				do so by visiting your Profile in the Account menu.
			</p>
		@endif
	</header>

	<form method="POST" action="{{ request()->routeIs('profile.edit') ? route('profile.update-hero-registration') : route('profile.register-hero') }}" class="mt-6 space-y-6">
		@csrf
		@method('post')

		<h3 class="text-lg font-medium text-seance-200">Public Information</h3>
		<p class="mt-2 text-mm text-seance-200">
			This information is <strong>visible to other Heroes and may be included in promotional material</strong>.
			We reserve the right to modify your information for appropriateness. Do not share your exact location, you
			may leave it blank or enter something regional like "Chicago IL" or "Florida".</p>
		@if(request()->routeIs('profile.hero-registration'))
			<div>
				<x-input-label for="name" class="block text-sm font-medium text-seance-200" :value="__('Hero Name')"/>
				<x-text-input id="name" name="first_name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" autofocus autocomplete="name"/>
				<x-input-error class="mt-2" :messages="$errors->get('name')"/>
			</div>
		@endif
		<div>
			<x-input-label for="location" class="block text-sm font-medium text-seance-200" :value="__('Location')"/>
			<x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $user->location)" autofocus autocomplete="location"/>
			<x-input-error class="mt-2" :messages="$errors->get('location')"/>
		</div>

		<div>
			<x-input-label for="public_profile" class="block text-sm font-medium text-seance-200" :value="__('Public Profile')"/>
			<x-text-input id="public_profile" name="public_profile" type="text" class="mt-1 block w-full" :value="old('public_profile', $user->public_profile)" autofocus autocomplete="public_profile"/>
			<x-input-error class="mt-2" :messages="$errors->get('location')"/>
		</div>

		<h3 class="text-lg font-medium text-seance-200">Personal Information</h3>
		<p class="mt-2 text-mm text-seance-200">
			The rest of this information is only available to system admins and quest managers who are vetted by Tabletop Gaymers.
			This information will only be used to contact you about your quests and other hero-related information. If you really
			don't want us to have your first or last name, please use pseudonyms as these fields are required. We will not share
			this information without your permission.</p>
		<div>
			<x-input-label for="first_name" class="block text-sm font-medium text-seance-200" :value="__('First/Given Name')"/>
			<x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" autofocus autocomplete="first_name"/>
			<x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
		</div>

		<div>
			<x-input-label for="last_name" class="block text-sm font-medium text-seance-200" :value="__('Last/Family Name')"/>
			<x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" autofocus autocomplete="last_name"/>
			<x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
		</div>

		<div>
			<x-input-label for="pronouns" class="block text-sm font-medium text-seance-200" :value="__('Pronouns')"/>
			<x-text-input id="pronouns" name="pronouns" type="text" class="mt-1 block w-full" :value="old('pronouns', $user->pronouns)" autofocus/>
			<x-input-error class="mt-2" :messages="$errors->get('pronouns')"/>
		</div>

		<div class="space-y-4">
			{{-- Phone Number Input (Optional) --}}
			<div>
				<x-input-label for="phone_number" class="block text-sm font-medium text-seance-200" :value="__('Phone Number (Optional)')"/>
				<x-text-input id="phone_number" name="phone_number" type="tel" class="mt-1 block w-full" :value="old('phone_number', $user->phone_number)"/>
				<x-input-error class="mt-2" :messages="$errors->get('phone_number')"/>
			</div>

			<h3 class="text-lg font-medium text-seance-200">Location Details</h3>
			<p class="mt-2 text-mm text-seance-200">
				We ask for your address only for specific opportunities in your area or the off chance we're able to send you rewards
				or materials related to some quests. You may provide as much or as little specificity as you wish. For example,
				you can choose to leave off your street address. None of these fields are required.</p>

			{{-- Country Input --}}
			<div>
				<x-input-label for="country" class="block text-sm font-medium text-seance-200" :value="__('Country')"/>
				<x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $user->country)"/>
				<x-input-error class="mt-2" :messages="$errors->get('country')"/>
			</div>

			{{-- Address Input --}}
			<div>
				<x-input-label for="address" class="block text-sm font-medium text-seance-200" :value="__('Address')"/>
				<x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $user->address)"/>
				<x-input-error class="mt-2" :messages="$errors->get('address')"/>
			</div>

			{{-- City Input --}}
			<div>
				<x-input-label for="city" class="block text-sm font-medium text-seance-200" :value="__('City')"/>
				<x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $user->city)"/>
				<x-input-error class="mt-2" :messages="$errors->get('city')"/>
			</div>

			{{-- State Input --}}
			<div>
				<x-input-label for="state" class="block text-sm font-medium text-seance-200" :value="__('State')"/>
				<x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)"/>
				<x-input-error class="mt-2" :messages="$errors->get('state')"/>
			</div>

			{{-- Zip Code Input --}}
			<div>
				<x-input-label for="zip_code" class="block text-sm font-medium text-seance-200" :value="__('Zip Code')"/>
				<x-text-input id="zip_code" name="zip_code" type="text" class="mt-1 block w-full" :value="old('zip_code', $user->zip_code)"/>
				<x-input-error class="mt-2" :messages="$errors->get('zip_code')"/>
			</div>

			{{-- Textarea for Past Volunteer Experience --}}
			<h3 class="text-lg font-medium text-seance-200">Past Volunteer Experience </h3>
			<p class="mt-2 text-mm text-seance-200">
				If you've volunteered for Tabletop Gaymers in the past, tell us about it! We'll review your info, and it might
				give you bonus XP! Please leave the field blank if you haven't volunteered for TG before.</p>
			<div>
				<x-input-label for="past_volunteer_experience" class="block text-sm font-medium text-seance-200" :value="__('Past Volunteer Experience')"/>
				<textarea id="past_volunteer_experience" name="past_volunteer_experience"
						  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('past_volunteer_experience', $user->past_volunteer_experience) }}</textarea>
				<x-input-error class="mt-2" :messages="$errors->get('past_volunteer_experience')"/>
			</div>
		</div>


		<div class="flex items-center gap-4">
			<x-primary-button>{{ __('Save') }}</x-primary-button>

			@if (session('status') === 'profile-updated')
				<p
					x-data="{ show: true }"
					x-show="show"
					x-transition
					x-init="setTimeout(() => show = false, 2000)"
					class="text-sm text-gray-400"
				>{{ __('Saved.') }}</p>
			@endif
		</div>
	</form>
</section>