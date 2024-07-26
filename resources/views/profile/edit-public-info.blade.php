<x-app-layout>
	<x-slot name="header">
		{{ __('Public Information') }}
	</x-slot>

	<div class="main-content">
		<form method="POST" action="{{ route('profile.submit-public-info') }}">
			@csrf
			@method('post')
			@include('profile.partials.form-public-info')

			<input type="hidden" name="hero_id" value="{{ $hero->id }}">

			<x-primary-button class="my-4">{{ __('Save Public Information') }}</x-primary-button>
			<span class="inline-flex px-4"><a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a></span>
		</form>
	</div>

</x-app-layout>