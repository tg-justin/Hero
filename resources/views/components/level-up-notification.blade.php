@props(['message'])

{{-- Glow Animation --}}
<style>
	@keyframes glow {
		0% {
			box-shadow: 0 0 10px #f97316;
		}
		/* Orange glow */
		50% {
			box-shadow: 0 0 20px #fb923c;
		}
		/* Brighter orange glow */
		100% {
			box-shadow: 0 0 10px #f97316;
		}
	}
</style>

{{-- Modal Overlay --}}
<div id="level-up-modal" class="fixed inset-0 flex items-center justify-center z-50" style="background-color: rgba(0, 0, 0, 0.5);">
	<div class="bg-gradient-to-br from-seance-700 to-seance-800 p-8 rounded-lg shadow-2xl animate-bounce relative" style="animation: glow 2s ease-in-out infinite;">
		{{-- Close Button --}}
		<button id="close-notification-button" type="button" class="absolute top-2 right-2 text-white bg-red-500 hover:bg-red-600 rounded-full p-2">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
				<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
					  clip-rule="evenodd"/>
			</svg>
		</button>

		{{-- Content --}}
		<div class="flex items-center justify-center mb-4">
			<svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-400 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
			</svg>
		</div>

		<p class="text-4xl font-extrabold text-center text-yellow-400 mb-4">Level Up!</p>
		<p class="text-lg text-center text-white">{{ $message }}</p>


	</div>
</div>

<script>
	document.getElementById('close-notification-button').addEventListener('click', function () {
		this.parentElement.parentElement.remove(); // Remove the entire notification container
	});
</script>

