<x-app-layout>
	<x-slot name="header">
		{{ __('Change Password') }}
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-4">
				<form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
					@csrf
					@method('put')
					@include('profile.partials.form-change-password')
					<x-primary-button>{{ __('Change Password') }}</x-primary-button>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>