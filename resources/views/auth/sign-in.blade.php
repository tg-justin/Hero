<x-guest-layout>
	<div class="main-content">

		<x-auth-session-status class="mb-4 text-xl text-center" :status="session('status')"/>

		<h2 class="text-2xl font-bold text-seance-800 mb-4">Sign In</h2>

		<form method="POST" action="{{ route('sign-in') }}" class="space-y-4">
			@csrf

			{{-- Email Input --}}
			<div>
				<x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-seance-700"/>
				<x-text-input id="email" type="email" name="email" class="block mt-1 w-full"
							  :value="old('email')" required autofocus autocomplete="username"/>
				<x-input-error :messages="$errors->get('email')" class="mt-2"/>
			</div>

			{{-- Password Input --}}
			<div class="mt-4">
				<x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-seance-700"/>
				<x-text-input id="password" type="password" name="password" required autocomplete="current-password"
							  class="block mt-1 w-full"/>
				<x-input-error :messages="$errors->get('password')" class="mt-2"/>
			</div>

			<div class="block mt-4 justify-items-center">
				<x-primary-button class="float-right ml-4 bg-seance-700 hover:bg-seance-800 text-white rounded-md">
					{{ __('Log in') }}
				</x-primary-button>
				<div class="float-left">
					<a class="no-underline text-base text-gray-600"
					   href="{{ route('register') }}">Need to Register?</a><br/>
					<a class="no-underline text-base text-gray-600"
					   href="{{ route('password.request') }}">Forgot your password?</a>
				</div>
			</div>
		</form>
	</div>
</x-guest-layout>