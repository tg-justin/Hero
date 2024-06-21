<x-app-layout>
	<x-slot name="header">
		{{ __('Edit Category') }}
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-slate-700">

					@if ($errors->any())
						<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif

					@include('categories.form')
				</div>
			</div>
		</div>
	</div>
</x-app-layout>