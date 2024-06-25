<x-app-layout>
	<x-slot name="header">
		{{ __('Hero Registration') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-4">
				<p>After you complete this registration, you will be promoted to <strong>Level 1</strong> and
					will be able to view and accept other quests. If you ever need to change this information, you can
					do so by visiting your Profile in the Account menu.</p>
				<form method="POST" action="{{ route('profile.submit-hero-registration') }}" class="mt-6 space-y-6">
					@csrf
					@method('post')

					@include('profile.partials.form-public-info')
					@include('profile.partials.form-personal-info')
					@include('profile.partials.form-mailing-address')
					@include('profile.partials.form-volunteer-experience')

					<x-primary-button>{{ __('Submit Hero Registration') }}</x-primary-button>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>