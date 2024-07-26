<x-app-layout>
	<x-slot name="header">
		{{ __('Personal Information') }}
	</x-slot>

	<div class="main-content">
		<form method="POST" action="{{ route('profile.submit-personal-info') }}" class="mt-6 space-y-6">
			@csrf
			@method('post')
			@include('profile.partials.form-personal-info')
			<input type="hidden" name="hero_id" value="{{ $hero->id }}">

			<x-primary-button class="my-4">Save Personal Information</x-primary-button>
			<span class="inline-flex px-4"><a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a></span>
		</form>
	</div>

</x-app-layout>