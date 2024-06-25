<div class="flex items-center gap-4">
	<x-primary-button>{{ __('Save') }}</x-primary-button>

	@if (session('status') === 'profile-updated')
		<p
			x-data="{ show: true }"
			x-show="show"
			x-transition
			x-init="setTimeout(() => show = false, 2000)"
			class="text-sm text-gray-400"
		>{{ __('Saved.') }}</p>
	@endif
</div>