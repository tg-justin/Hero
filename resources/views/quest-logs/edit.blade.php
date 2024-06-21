<x-app-layout>
	<x-slot name="header">
		{{ __('Edit Quest Log for ') }} {{ $questLog->user->name }} - {{ $questLog->quest->title }}
	</x-slot>

	<div class="py-12">
		@include('quest-logs.partials.edit-form')
	</div>
</x-app-layout>