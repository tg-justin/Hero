<div class="bg-gradient-to-br from-seance-200 to-seance-300 p-6 rounded-lg shadow-lg flex items-center">
    <div class="flex flex-col items-center mr-4">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-16 h-16 rounded-full bg-seance-700">
            <text x="50%" y="55%" dominant-baseline="central" text-anchor="middle" font-size="12" fill="white">{{ substr($user->name, 0, 1) }}</text>
        </svg>
        <span class="text-xs text-gray-600 mt-2">Level {{ $user->level }} <br/> {{ $user->levelName }}</span>
    </div>
    <div>
        <h3 class="text-lg font-semibold text-seance-800 mb-2">{{ $user->name }}</h3>
        <div class="flex items-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.736 5.943 5.522 3 10 3s8.264 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.736 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-seance-700">{{ $user->totalxp() }} Total xp</span>
        </div>
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm text-seance-700">{{ $user->completedQuests()->count() }} Quests Completed</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
            <div class="bg-seance-600 h-2.5 rounded-full" style="width: {{ $user->xpPercentage() }}%;"></div>
        </div>
    </div>
</div>
