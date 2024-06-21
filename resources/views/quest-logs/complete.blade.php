<x-app-layout>
	<x-slot name="header">
		{{ __('Complete Quest: ') }} {{ $questLog->quest->title }}
	</x-slot>
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-6">
				<div class="mb-5">
					<h2>Congratulations on completing your quest!</h2>
					<p>To help us verify your progress and award you the appropriate rewards, please provide a detailed description of your quest experience in the box below.</p>
					<p>Here's what we'd love to know:</p>
					<p><strong>Summary of Actions</strong>: Briefly describe the key actions you took to accomplish the quest's objectives.</p>
					<p><strong>Challenges Faced</strong>: Did you encounter any obstacles or difficulties during the quest? How did you overcome them?</p>
					<p><strong>Lessons Learned</strong>: What did you learn from this experience? Did you gain any new skills or knowledge?</p>
					<p><strong>Proof of Completion</strong>: If applicable, include any relevant information that proves you completed the quest (e.g., screenshots, links to files, etc.).</p>
				</div>

				<form action="{{ route('quest-log.complete', $questLog) }}" method="POST">
					@csrf

					<div class="mb-4">
						<label for="completion_details" class="block text-gray-700 text-sm font-bold mb-2">Completion Details:</label>
						<textarea name="completion_details" placeholder="Describe how you completed the quest" class="tinymce-basic form-textarea w-full" rows="5"></textarea>
						@error('completion_details')
						<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
						@enderror
					</div>

					{{--<div class="mb-4">
						<label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
						<select name="status" id="status" class="form-select w-full">
							<option value="Completed" {{ $questLog->status === 'Completed' ? 'selected' : '' }}>Completed</option>
						</select>
					</div>--}}

					<button type="submit" class="text-white focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">
						Complete Quest
					</button>
				</form>
			</div>
		</div>
	</div>
</x-app-layout>