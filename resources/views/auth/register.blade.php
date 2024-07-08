<x-guest-layout>
	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-6">

			<div class="bg-white/75 overflow-hidden shadow-xl rounded-lg p-4 md:p-6">
				<h2 class="text-2xl font-bold text-seance-800 mb-4">Join the Adventure</h2>

				<form method="POST" action="{{ route('register') }}" class="space-y-4">
					@csrf

					{{-- Email Input --}}
					<div>
						<x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-seance-700"/>
						<x-text-input id="email" type="email" name="email" class="block mt-1 w-full"
									  :value="old('email')" required autofocus autocomplete="username"/>
						<x-input-error :messages="$errors->get('email')" class="mt-2"/>
					</div>

					{{-- Password Input --}}
					<div>
						<x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-seance-700"/>
						<x-text-input id="password" type="password" name="password" required autocomplete="new-password"
									  class="block mt-1 w-full"/>
						<x-input-error :messages="$errors->get('password')" class="mt-2"/>
					</div>

					{{-- Confirm Password Input --}}
					<div>
						<x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-seance-700"/>
						<x-text-input id="password_confirmation" type="password" name="password_confirmation" required
									  class="block mt-1 w-full"/>
						<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
					</div>

					<div class="block mt-4 items-baseline">
						<x-primary-button class="float-right ml-4 bg-seance-700 hover:bg-seance-800 text-white rounded-md">
							{{ __('Register') }}
						</x-primary-button>
						<div class="float-left">
							<a href="{{ route('login') }}" class="no-underline text-base text-gray-600">
								{{ __('Already registered?') }}</a>
						</div>
					</div>
				</form>

			</div>
		</div>
	</div>
</x-guest-layout>