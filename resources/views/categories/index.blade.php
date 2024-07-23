<x-app-layout>
	<x-slot name="header">
		{{ __('Category Board') }}
	</x-slot>
	<x-slot name="headerRight">
		@if (Auth::user()->hasRole('manager'))
			<a href="{{ route('categories.create') }}" class="header-button">NEW CATEGORY</a>
		@endif
	</x-slot>

	<div class="main-table">
		<table class="table-seance">
			<thead>
			<tr>
				<th scope="col" class="tracking-wider">
					Category Name
				</th>
				<th scope="col" class="tracking-wider">
					Description
				</th>
				<th scope="col" class="tracking-wider">Actions</th>
			</tr>
			</thead>
			<tbody class="bg-white divide-y divide-slate-200">
			@foreach ($categories as $category)
				<tr>
					<td>
						{{ $category->name }}
					</td>
					<td>{{ $category->description }}</td>
					<td>
						<div class="flex space-x-2">
							<a href="{{ route('categories.edit', $category) }}" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Edit</a>
							<form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this quest?');">
								@csrf
								@method('DELETE')
								<button type="submit" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Delete</button>
							</form>
						</div>
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	{{ $categories->appends(request()->except('page'))->links() }}
</x-app-layout>