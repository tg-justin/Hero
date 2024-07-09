<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
	<form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST">
		@csrf
		@if (isset($category))
			@method('PUT')
		@endif
		<div>
			<label for="name" class="block text-sm font-medium text-gray-700">Name</label>
			<input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
			@error('name')
			<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
			@enderror
		</div>

		<div class="mt-4">
			<label for="description" class="block text-sm font-medium text-gray-700">Description</label>
			<input type="text" name="description" id="description" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
				   value="{{ old('description', $category->description ?? '') }}"></input>
		</div>

		<div class="mt-4">
			<button type="submit" class="tg-button-purple">
				{{ isset($category) ? 'Update Category' : 'Create Category' }}
			</button>
			<a href="{{ url()->previous() }}" class="tg-button-gray">Cancel</a>
		</div>
	</form>
</div>
