<x-app-layout>
	<x-slot name="header">
		{{ __('Create Category') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-slate-700">
					@include('categories.form')
				</div>
			</div>
		</div>
	</div>
</x-app-layout>