@props(['questsByCategory'])

<div class="bg-white p-6 rounded-lg shadow-md">
	<h3 class="text-lg font-semibold mb-4">Quests by Category</h3>
	<ul class="list-none">
		@foreach ($questsByCategory as $item)
			<li class="flex items-center mb-2">
				<span class="text-seance-700">{{ $item->category->name }}:</span>
				<span class="ml-auto text-gray-600">{{ $item->total }}</span>
			</li>
		@endforeach
	</ul>
</div>
