<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Registration') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-4">
				@include('profile.partials.update-hero-registration-form')
			</div>
		</div>
	</div>
</x-app-layout>