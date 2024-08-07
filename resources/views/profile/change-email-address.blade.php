@php use Illuminate\Contracts\Auth\MustVerifyEmail; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Change Email Address') }}
	</x-slot>

	<div class="main-content">
		<form id="send-verification" method="post" action="{{ route('verification.send') }}">
			@csrf
		</form>

		<form method="post" action="{{ route('profile.submit-change-email-address') }}">
			@csrf
			@method('post')

			<h2>Changing Your Email Address</h2>
			<p>If you change your email address, you will need to verify the new email address before you can log in with it.</p>

			<div class="mb-4">
				<label for="email" class="field-label field-required">Email Address</label>
				<x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $hero->email)" maxsize="255" required autocomplete="email"/>
				<x-input-error class="error-message" :messages="$errors->get('email')"/>

				@if ($hero instanceof MustVerifyEmail && ! $hero->hasVerifiedEmail())
					<div>
						<p class="text-sm mt-2 text-gray-200">
							{{ __('Your email address is unverified.') }}

							<button form="send-verification" class="underline text-sm text-gray-400 hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800">
								{{ __('Click here to re-send the verification email.') }}
							</button>
						</p>

						@if (session('status') === 'verification-link-sent')
							<p class="mt-2 font-medium text-sm text-green-400">
								{{ __('A new verification link has been sent to your email address.') }}
							</p>
						@endif
					</div>
				@endif
			</div>
			<x-primary-button>{{ __('Change Email Address') }}</x-primary-button>
			<span class="inline-flex px-2"><a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a></span>
		</form>
	</div>
</x-app-layout>