<x-app-layout>
	<x-slot name="header">
		{{ __('Public Information') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-4">
				<form method="POST" action="{{ route('profile.submit-public-info') }}" class="mt-6 space-y-6">
					@csrf
					@method('post')
					@include('profile.partials.form-public-info')
					<input type="hidden" name="hero_id" value="{{ $hero->id }}">
					<x-primary-button>{{ __('Save Public Information') }}</x-primary-button>
					<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>