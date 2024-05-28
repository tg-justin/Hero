@props(['heroes'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold mb-4">Leaderboard</h3>
    <ol class="list-decimal pl-5">
        @foreach ($heroes as $index => $hero)
            <li class="flex items-center mb-2">
                <span class="font-bold mr-2">{{ $index + 1 }}. </span>
                <span class="text-seance-700">{{ $hero->name }}</span>
                <span class="ml-auto text-gray-600">{{ $hero->totalPoints() }}</span>
            </li>
        @endforeach
    </ol>
</div>
