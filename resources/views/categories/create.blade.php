<x-app-layout>
	<x-slot name="header">
		{{ __('Create Category') }}
	</x-slot>

	<div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
		<div class="p-6 text-slate-700">
			@include('categories.form')
		</div>
	</div>

</x-app-layout>