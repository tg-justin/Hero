<x-app-layout>
	<x-slot name="header">
		<h2 class="font-extrabold text-3xl text-seance-200">
			{{ __('Hero Registration') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="p-4 sm:p-8 bg-seance-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('profile.partials.update-hero-registration-form')
				</div>
			</div>

		</div>
	</div>
</x-app-layout>
