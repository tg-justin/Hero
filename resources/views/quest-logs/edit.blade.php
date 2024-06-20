<x-app-layout>
	<x-slot name="header">
		<h2 class="font-extrabold text-3xl text-seance-200 leading-tight">
			{{ __('Edit Quest Log for ') }} {{ $questLog->user->name }} - {{ $questLog->quest->title }}
		</h2>
	</x-slot>

	<div class="py-12">
		@include('quest-logs.partials.edit-form')
	</div>
</x-app-layout>

