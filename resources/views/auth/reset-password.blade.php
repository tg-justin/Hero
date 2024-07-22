<x-guest-layout>
	<div class="main-outer">
		<div class="main-inner">

			<div class="main-content">
				<h2 class="text-2xl font-bold text-seance-800 mb-4">Choose New Password</h2>

				<form method="POST" action="{{ route('password.store') }}">
					@csrf

					<!-- Password Reset Token -->
					<input type="hidden" name="token" value="{{ $request->route('token') }}">
					<input type="hidden" name="email" value="{{ $request->email }}">

					<!-- Email Address DISABLED -->
					<div>
						<x-input-label for="email" :value="__('Email')"/>
						<x-text-input disabled id="email" class="block mt-1 w-full disabled:bg-gray-200" type="email" name="email" :value="old('email', $request->email)"/>
						<x-input-error :messages="$errors->get('email')" class="mt-2"/>
					</div>

					<!-- Password -->
					<div class="mt-4">
						<x-input-label for="password" :value="__('Password')"/>
						<x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autofocus autocomplete="new-password"/>
						<x-input-error :messages="$errors->get('password')" class="mt-2"/>
					</div>

					<!-- Confirm Password -->
					<div class="mt-4">
						<x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

						<x-text-input id="password_confirmation" class="block mt-1 w-full"
									  type="password"
									  name="password_confirmation" required autocomplete="new-password"/>

						<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
					</div>

					<div class="flex items-center justify-end mt-4">
						<x-primary-button>
							{{ __('Reset Password') }}
						</x-primary-button>
					</div>
				</form>
			</div>
		</div>
	</div>
</x-guest-layout>