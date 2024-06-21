<x-app-layout>
	<x-slot name="header">
		<span class="font-extrabold text-3xl text-seance-200 leading-tight">
			{{ __('Edit Quest Log for ') }} {{ $questLog->user->name }} - {{ $questLog->quest->title }}
		</span>
	</x-slot>

	<div class="py-12">
		@include('quest-logs.partials.edit-form')
	</div>
</x-app-layout>

