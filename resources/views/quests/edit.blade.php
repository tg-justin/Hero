<x-app-layout>
	<x-slot name="header">
		{{ __('Edit Quest') }}: {{$quest->title}}
	</x-slot>

	<div class="main-content">
		@if ($errors->any())
			<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif

		<x-quest-form :quest="$quest" :feedback_types="$feedback_types"/>
	</div>

</x-app-layout>