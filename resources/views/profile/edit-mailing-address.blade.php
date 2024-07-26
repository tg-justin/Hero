<x-app-layout>
	<x-slot name="header">
		{{ __('Mailing Address') }}
	</x-slot>

	<div class="main-content">
				<form method="POST" action="{{ route('profile.submit-mailing-address') }}" class="mt-6 space-y-6">
					@csrf
					@method('post')
					@include('profile.partials.form-mailing-address')
					<input type="hidden" name="hero_id" value="{{ $hero->id }}">

					<x-primary-button class="my-4">{{ __('Save Mailing Address') }}</x-primary-button>
					<span class="inline-flex px-4"><a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a></span>
				</form>
			</div>

</x-app-layout>