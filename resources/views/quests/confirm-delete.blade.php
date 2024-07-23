<x-app-layout>
	<x-slot name="header">
		{{ __('Confirm Quest Deletion') }}: {{$quest->title}}
	</x-slot>
	
	<div class="main-content">
		<p>Are you sure you want to delete the quest "{{ $quest->title }}"?</p>

		<h2 class="text-red-600 mt-4">This action cannot be undone!</h2>
		<div class="max-w-64 m-auto">
			<form action="{{ route('quests.destroy', $quest) }}" method="POST">
				@csrf
				@method('DELETE')
				<div class="mx-auto">
					<button type="submit" class="tg-button-purple" style="width: 100%">
						Yes, Delete
					</button>
				</div>
			</form>
			<div class="mx-auto">
				<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
			</div>
		</div>
	</div>

</x-app-layout>