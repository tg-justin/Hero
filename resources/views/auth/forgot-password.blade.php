<x-guest-layout>
	<!-- Session Status -->
	<x-auth-session-status class="alert-success" :status="session('status')"/>

	<div class="main-content">
		<h2 class="text-2xl font-bold text-seance-800 mb-4">Forgot Password?</h2>

		<div class="mb-4 text-base text-gray-600 dark:text-gray-400">
			No problem. Enter your email address and we'll send you a password reset link.
		</div>

		<form method="POST" action="{{ route('password.email') }}">
			@csrf

			<!-- Email Address -->
			<div>
				<x-input-label for="email" :value="__('Email')"/>
				<x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus/>
				<x-input-error :messages="$errors->get('email')" class="mt-2"/>
			</div>

			<div class="flex items-center justify-end mt-4">
				<x-primary-button>
					{{ __('Email Password Reset Link') }}
				</x-primary-button>
			</div>
		</form>
	</div>
</x-guest-layout>