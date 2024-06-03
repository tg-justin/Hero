<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Quest Log for ') }} {{ $questLog->user->name }} - {{ $questLog->quest->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('quest-logs.update', $questLog) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                            <select name="status" id="status" class="form-select w-full">
                                <option value="Accepted" {{ $questLog->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="In Progress" {{ $questLog->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="Completed" {{ $questLog->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Failed" {{ $questLog->status == 'Failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('status')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="xp_awarded" class="block text-gray-700 text-sm font-bold mb-2">XP Awarded:</label>
                            <input type="number" name="xp_awarded" id="xp_awarded" class="form-input w-full" value="{{ old('xp_awarded', $questLog->xp_awarded) }}" required>
                            @error('xp_awarded')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="xp_bonus" class="block text-gray-700 text-sm font-bold mb-2">Bonus XP:</label>
                            <input type="number" name="xp_bonus" id="xp_bonus" class="form-input w-full" value="{{ old('xp_bonus', $questLog->xp_bonus) }}">
                            @error('xp_bonus')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-primary-button>Update Quest Log</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

