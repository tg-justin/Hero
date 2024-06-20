<x-app-layout>
	<x-slot name="header">
		<h2 class="font-extrabold text-3xl text-seance-200">
			{{ __('Profile') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			@if (session('success'))
				<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			<div class="p-4 sm:p-8 bg-seance-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('profile.partials.update-profile-information-form')
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-seance-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('profile.partials.update-hero-registration-form')
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-seance-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('profile.partials.update-password-form')
				</div>
			</div>

			<div class="p-4 sm:p-8 bg-seance-800 shadow sm:rounded-lg">
				<div class="max-w-xl">
					@include('profile.partials.delete-user-form')
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
