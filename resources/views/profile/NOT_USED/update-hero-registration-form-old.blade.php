<section>
	<header>
		@if(request()->routeIs('profile.hero-registration'))
			<h2>{{ __('Hero Registration') }}</h2>
			<p>After you complete this registration, you will be promoted to <strong>Level 1 </strong> and
				will be able to view and accept other quests. If you ever need to change this information, you can
				do so by visiting your Profile in the Account menu.
			</p>
		@endif
	</header>

	{{--	<form method="POST" action="{{ request()->routeIs('profile.edit') ? route('profile.update-hero-registration') : route('profile.register-hero') }}" class="mt-6 space-y-6">--}}
	{{--	<form method="POST" action="{{ route('profile.update-hero-registration') }}" class="mt-6 space-y-6">--}}
	<form method="POST" action="{{ request()->routeIs('profile.edit') ? route('profile.update-hero-registration') : route('profile.register-hero') }}" class="mt-6 space-y-6">
		@csrf
		@method('post')

		<h2>Public Information</h2>
		<p>This information is <strong>visible to other Heroes and may be included in our promotional material</strong>.
			We reserve the right to modify your information for appropriateness. Do not share your exact location, you
			may leave it blank or enter something regional like "Chicago IL" or "Florida".</p>

		@if(request()->routeIs('profile.hero-registration'))
			<div>
				<x-input-label for="name" :value="__('Hero/Display Name')"/>
				<x-text-input id="name" name="first_name" type="text" class="block mt-1 w-full max-w-md" :value="old('name', $user->name)" autofocus autocomplete="name"/>
				<x-input-error class="mt-2" :messages="$errors->get('name')"/>
			</div>
		@endif

		<div>
			<x-input-label for="location" :value="__('Your Location')"/>
			<x-text-input id="location" name="location" type="text" class="block mt-1 w-full max-w-md" :value="old('location', $user->location)" autocomplete="location"/>
			<x-input-error class="mt-2" :messages="$errors->get('location')"/>
		</div>

		<div>
			<x-input-label for="public_profile" :value="__('Your Publicly Visible Profile')"/>
			<textarea id="public_profile" name="public_profile"
					  class="tinymce mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('public_profile', $user->public_profile) }}</textarea>
			<x-input-error class="mt-2" :messages="$errors->get('public_profile')"/>
		</div>

		<h2>Personal Information</h2>
		<p>This information is only available to you, system admins, and quest managers who are vetted by Tabletop Gaymers.
			This information will only be used to contact you about your quests and other hero-related information. If you really
			don't want us to have your first or last name, please use pseudonyms as these fields are required.
			<strong>We will not share this information without your permission.</strong></p>
		<div>
			<x-input-label for="first_name" :value="__('First/Given Name')"/>
			<x-text-input id="first_name" name="first_name" type="text" class="block mt-1 w-full max-w-md" :value="old('first_name', $user->first_name)" autocomplete="first_name"/>
			<x-input-error class="mt-2" :messages="$errors->get('first_name')"/>
		</div>

		<div>
			<x-input-label for="last_name" :value="__('Last/Family Name')"/>
			<x-text-input id="last_name" name="last_name" type="text" class="block mt-1 w-full max-w-md" :value="old('last_name', $user->last_name)" autocomplete="last_name"/>
			<x-input-error class="mt-2" :messages="$errors->get('last_name')"/>
		</div>

		<div>
			<x-input-label for="pronouns" :value="__('Pronouns')"/>
			<x-text-input id="pronouns" name="pronouns" type="text" class="block mt-1 w-full max-w-xs" :value="old('pronouns', $user->pronouns)"/>
			<x-input-error class="mt-2" :messages="$errors->get('pronouns')"/>
		</div>

		<div>
			<x-input-label for="phone_number" :value="__('Phone Number')"/>
			<x-text-input id="phone_number" name="phone_number" type="tel" class="block mt-1 w-full max-w-xs" :value="old('phone_number', $user->phone_number)"/>
			<x-input-error class="mt-2" :messages="$errors->get('phone_number')"/>
		</div>

		<div>
			<x-input-label for="timezone" :value="__('Time Zone')"/>
			<x-text-input id="timezone" name="timezone" class="block mt-1 w-full max-w-xs" :value="old('timezone', $user->timezone)"/>
			<x-input-error class="mt-2" :messages="$errors->get('timezone')"/>
		</div>

		<h2>Mailing Address</h2>
		<p>This information is only available to you, system admins, and quest managers who are vetted by Tabletop Gaymers.
			We ask for your mailing address to offer you opportunities specific to you location and if you earn any physical
			rewards as a result of the quests you complete. You may provide as much or as little specificity as you wish.
			For example, you can choose to leave off your street address. <strong>None of these fields are required.</strong></p>

		<div>
			<x-input-label for="address" :value="__('Street Address')"/>
			<x-text-input id="address" name="address" type="text" class="block mt-1 w-full max-w-md" :value="old('address', $user->address)"/>
			<x-input-error class="mt-2" :messages="$errors->get('address')"/>
		</div>

		{{-- City Input --}}
		<div>
			<x-input-label for="city" :value="__('City')"/>
			<x-text-input id="city" name="city" type="text" class="block mt-1 w-full max-w-md" :value="old('city', $user->city)"/>
			<x-input-error class="mt-2" :messages="$errors->get('city')"/>
		</div>

		{{-- State Input --}}
		<div>
			<x-input-label for="state" :value="__('State/Providence')"/>
			<x-text-input id="state" name="state" type="text" class="block mt-1 w-full max-w-md" :value="old('state', $user->state)"/>
			<x-input-error class="mt-2" :messages="$errors->get('state')"/>
		</div>

		{{-- Zip Code Input --}}
		<div>
			<x-input-label for="zip_code" :value="__('Zip/Postal Code')"/>
			<x-text-input id="zip_code" name="zip_code" type="text" class="block mt-1 w-full max-w-xs" :value="old('zip_code', $user->zip_code)"/>
			<x-input-error class="mt-2" :messages="$errors->get('zip_code')"/>
		</div>

		{{-- Country Input --}}
		<div>
			<x-input-label for="country" class="block text-sm font-medium" :value="__('Country')"/>
			<x-text-input id="country" name="country" type="text" class="block mt-1 w-full max-w-xs" :value="old('country', $user->country)"/>
			<x-input-error class="mt-2" :messages="$errors->get('country')"/>
		</div>

		{{-- Textarea for Past Volunteer Experience --}}
		<h2>Past Volunteer Experience with Tabletop Gaymers</h2>
		<p class="mt-2 text-mm">
			If you've volunteered for Tabletop Gaymers in the past, tell us about it! We'll review your info, and it might
			give you bonus XP! Please leave the field blank if you haven't volunteered for TG before.</p>

		<div>
			<x-input-label for="past_volunteer_experience" :value="__('Past Volunteer Experience')"/>
			<textarea id="past_volunteer_experience" name="past_volunteer_experience"
					  class="tinymce mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('past_volunteer_experience', $user->past_volunteer_experience) }}</textarea>
			<x-input-error class="mt-2" :messages="$errors->get('past_volunteer_experience')"/>
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