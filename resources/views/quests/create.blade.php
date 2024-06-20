<x-app-layout>
	<x-slot name="header">
		<h2 class="font-semibold text-xl text-seance-200 leading-tight">
			{{ __('Create Quest') }}
		</h2>
	</x-slot>

	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-slate-50 overflow-hidden shadow-sm sm:rounded-lg">
				<div class="p-6 text-slate-700">
					<x-quest-form/>
				</div>
			</div>
		</div>
	</div>
</x-app-layout>
