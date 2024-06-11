@props(['heroes', 'title'])

<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>
    <ul class="list-none">
        @foreach ($heroes as $hero)
            <li class="flex items-center mb-2">
                <a href="{{ route('users.quest-logs', $hero) }}" class="text-seance-700 hover:underline">{{ $hero->name }}</a>
                <span class="ml-auto text-gray-600">{{ $hero->totalxp() }}</span>
            </li>
        @endforeach
    </ul>
</div>
