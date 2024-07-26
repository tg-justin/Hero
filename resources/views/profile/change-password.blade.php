<x-app-layout>
	<x-slot name="header">
		{{ __('Change Password') }}
	</x-slot>

	<div class="main-content">
		<form method="post" action="{{ route('password.update') }}">
			@csrf
			@method('put')
			@include('profile.partials.form-change-password')
			<x-primary-button class="my-4">{{ __('Change Password') }}</x-primary-button>
			<span class="inline-flex px-4"><a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a></span>
		</form>
	</div>

</x-app-layout>