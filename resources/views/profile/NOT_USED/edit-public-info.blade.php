<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Registration') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-4">
				{{--				<form method="POST" action="{{ request()->routeIs('profile.edit') ? route('profile.update-hero-registration') : route('profile.register-hero') }}" class="mt-6 space-y-6">--}}
				<form method="POST" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
					@csrf
					@method('post')
					@include('profile.partials.update-public-info')
					@include('profile.partials.update-hero-registration-form')
				</form>
			</div>
		</div>
	</div>
</x-app-layout>