<x-primary-button
	x-data=""
	x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
>{{ __('Delete Account') }}</x-primary-button>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
	<form method="post" action="{{ route('profile.destroy') }}" class="p-6">
		@csrf
		@method('delete')

		<h2>Are you absolutely certain you want to DELETE your TG Hero account?</h2>

		<p>Once your account has been deleted, ALL of your information, quest history, and
			feedback will be <strong>permanently removed</strong>. This is your only warning.</p>
		<p>Enter your password to confirm this action.</p>

		<div class="mt-6">
			<x-input-label for="password" value="{{ __('Password') }}" class="sr-only"/>

			<x-text-input
				id="password"
				name="password"
				type="password"
				class="mt-1 block w-full"
				placeholder="{{ __('Password') }}"
			/>

			<x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2"/>
		</div>

		<div class="mt-6 flex justify-end">
			<x-secondary-button x-on:click="$dispatch('close')">
				{{ __('Cancel') }}
			</x-secondary-button>

			<x-primary-button class="ms-3">
				{{ __('Delete Account') }}
			</x-primary-button>
		</div>
	</form>
</x-modal>