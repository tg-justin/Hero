<x-app-layout>
	<x-slot name="header">
		{{ __('Create New Quest') }}
	</x-slot>

	<div class="main-content">
		<x-quest-form :quest="$quest" :feedback_types="$feedbackTypes"/>
	</div>
</x-app-layout>