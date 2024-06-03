@props(['message'])
<style>
    @keyframes glow {
        0% {
            box-shadow: 0 0 10px #f97316; /* Orange glow */
        }
        50% {
            box-shadow: 0 0 20px #fb923c; /* Brighter orange glow */
        }
        100% {
            box-shadow: 0 0 10px #f97316;
        }
    }
</style>
<div id="level-up-modal" 
    class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-gradient-to-br from-seance-700 to-seance-800 p-8 rounded-lg shadow-2xl z-50 animate-bounce" 
    style="animation: glow 2s ease-in-out infinite;">

    <div class="flex items-center justify-center mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /> 
        </svg>
    </div>

    <p class="text-4xl font-extrabold text-center text-yellow-400 mb-4">Level Up!</p>
    <p class="text-lg text-center text-white">{{ $message }}</p>
</div>
