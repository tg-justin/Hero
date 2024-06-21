<x-app-layout>
	<x-slot name="header">
		{{ __('Category Board') }}
	</x-slot>
	<x-slot name="headerRight">
		@if (Auth::user()->hasRole('manager'))
			<a href="{{ route('categories.create') }}" class="header-button">Create New Category</a>
		@endif
	</x-slot>

{{--	<x-slot name="header">--}}
{{--		<div class="flex justify-between items-center">--}}
{{--			<h2 class="font-extrabold text-3xl text-seance-200">Category Board</h2>--}}

{{--			<a href="{{ route('categories.create') }}" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">--}}
{{--				Create New Category--}}
{{--			</a>--}}
{{--		</div>--}}
{{--	</x-slot>--}}

	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			@if (session('success'))
				<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif

			<div class="overflow-x-auto shadow-xl rounded-lg">
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
										<button type="submit" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800" >Delete</button>
									</form>
								</div>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>{{ $categories->appends(request()->except('page'))->links() }}
		</div>
	</div>
</x-app-layout>