<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Registration') }}
	</x-slot>

	<div class="main-content">
		<p>After you complete this registration, you will be promoted to <strong>Level 1</strong> and
			will be able to view and accept other quests. If you ever need to change this information, you can
			do so by visiting your Profile in the Account menu.</p>
		<form method="POST" action="{{ route('profile.submit-hero-registration') }}">
			@csrf
			@method('post')

			@include('profile.partials.form-public-info')
			@include('profile.partials.form-personal-info')
			@include('profile.partials.form-mailing-address')
			@include('profile.partials.form-volunteer-experience')

			<div class="mb-4">
				<div class="flex items-center">
					<input type="checkbox" id="newsletter_opt_in" name="newsletter_opt_in" value="1" class="mt-8">
					<label for="newsletter_opt_in" class="field-label">Subscribe to our newsletter</label>
				</div>
				<span>Text about what this means.</span>
				<x-input-error :messages="$errors->get('newsletter_opt_in')" class="error-message"/>
			</div>

			<x-primary-button>{{ __('Submit Hero Registration') }}</x-primary-button>
		</form>
	</div>

</x-app-layout>