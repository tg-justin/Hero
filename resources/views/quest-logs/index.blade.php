<x-app-layout>
    <x-slot name="header">
        <h2 class="font-extrabold text-3xl text-seance-200">
            {{ __('Quest Log') }}
        </h2>
    </x-slot>
    <div class="py-12 bg-cover bg-center" >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            {{-- Display success message --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                    <p class="m-0">{{ session('success') }}</p>
                </div>
            @endif
            <div class="overflow-hidden shadow-xl rounded-lg">
                <x-hero-profile :user="$user" />
                @if ($questLogs->count() > 0)
                    <div class="overflow-x-auto shadow-xl rounded-lg">
                        <table class="table-seance">
                            <thead >
                            <tr>
                                <th scope="col" class="tracking-wider">Quest Title</th>
                                <th scope="col" class="tracking-wider">Status</th>
                                <th scope="col" class="tracking-wider hidden md:table-cell">XP Awarded</th>
                                <th scope="col" class="tracking-wider hidden md:table-cell">Bonus XP</th>
                                <th scope="col" class="tracking-wider">Actions</th>
                            </tr>

                            </thead>
                            <tbody>
                            @foreach ($questLogs as $questLog)
                                <tr>
                                    <td>
                                        <a href="{{ route('quests.show', $questLog->quest->id) }}">
                                            {{ $questLog->quest->title }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-slate-600 rounded {{ $questLog->statusColor }}">
                                            {{ $questLog->status }}
                                        </span>
                                    </td>
                                    <td class="hidden md:table-cell">{{ $questLog->xp_awarded }}</td>
                                    <td class="hidden md:table-cell">{{ $questLog->xp_bonus }}</td>
                                    <td>
                                        <a href="{{ route('quest-logs.edit', $questLog) }}" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                        <p>{{ $user->name }} has not accepted any quests yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

