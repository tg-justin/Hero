<x-guest-layout>
	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">

				<h2 class="text-3xl font-extrabold text-seance-800 dark:text-seance-800 mb-4">Join Our Guild</h2>

				<form method="POST" action="{{ route('register') }}" class="space-y-4">
					@csrf

					{{-- Name Input --}}
{{--					<div>--}}
{{--						<x-input-label for="name" :value="__('Hero Name')" class="block text-sm font-medium text-seance-700 dark:text-seance-700"/>--}}
{{--						<x-text-input id="name" class="block mt-1 w-full rounded-md border-seance-300 shadow-sm focus:ring-seance-500 focus:border-seance-500" type="text" name="name" :value="old('name')" required autofocus--}}
{{--									  autocomplete="name"/>--}}
{{--						<x-input-error :messages="$errors->get('name')" class="mt-2"/>--}}
{{--					</div>--}}

					{{-- Email Input --}}
					<div>
						<x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-seance-700 dark:text-seance-700"/>
						<x-text-input id="email" class="block mt-1 w-full rounded-md border-seance-300 shadow-sm focus:ring-seance-500 focus:border-seance-500" type="email" name="email" :value="old('email')" required
									  autocomplete="username"/>
						<x-input-error :messages="$errors->get('email')" class="mt-2"/>
					</div>

					{{-- Timezone Input --}}
{{--					<div class="mt-4">--}}
{{--						<x-input-label for="timezone" :value="__('Timezone')" class="block text-sm font-medium text-seance-700 dark:text-seance-700"/>--}}
{{--						<select id="timezone" name="timezone" class="block mt-1 w-full rounded-md border-seance-300 shadow-sm focus:ring-seance-500 focus:border-seance-500">--}}
{{--							@foreach ($timezones as $timezone)--}}
{{--								<option value="{{ $timezone }}"--}}
{{--										@if (old('timezone', 'America/Chicago') == $timezone) selected @endif>--}}
{{--									{{ $timezone }}--}}
{{--								</option>--}}
{{--							@endforeach--}}
{{--						</select>--}}
{{--						<x-input-error :messages="$errors->get('timezone')" class="mt-2"/>--}}
{{--					</div>--}}

					{{-- Password Input --}}
					<div>
						<x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-seance-700 dark:text-seance-700"/>
						<x-text-input id="password" class="block mt-1 w-full rounded-md border-seance-300 shadow-sm focus:ring-seance-500 focus:border-seance-500" type="password" name="password" required autocomplete="new-password"/>
						<x-input-error :messages="$errors->get('password')" class="mt-2"/>
					</div>

					{{-- Confirm Password Input --}}
					<div>
						<x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-sm font-medium text-seance-700 dark:text-seance-700"/>
						<x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md border-seance-300 shadow-sm focus:ring-seance-500 focus:border-seance-500" type="password" name="password_confirmation" required
									  autocomplete="new-password"/>
						<x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
					</div>

					<div class="flex items-center justify-end">
						<a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
						   href="{{ route('login') }}">
							{{ __('Already registered?') }}
						</a>
						<x-primary-button class="ml-4 bg-seance-700 hover:bg-seance-800 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-seance-500">
							{{ __('Register') }}
						</x-primary-button>
					</div>
				</form>

			</div>
		</div>
	</div>
</x-guest-layout>