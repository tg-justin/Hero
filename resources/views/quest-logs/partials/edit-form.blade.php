<form action="{{ route('quest-logs.update', $questLog) }}" method="POST">
	@csrf
	@method('PUT')

	<div class="bg-white overflow-hidden sm:rounded-lg">
		<div class="text-gray-900">
			<div class="mb-4">
				<x-input-label for="status" class="text-gray-700" :value="__('Status')"/>
				<select name="status" id="status" class="form-select w-full">
					@foreach($valid_statuses as $status)
						<option value="{{ $status }}" {{ old('status', $questLog->status) == $status ? 'selected' : '' }}>
							{{ $status }}
						</option>
					@endforeach
				</select>
				<x-input-error :messages="$errors->get('status')" class="mt-2"/>
			</div>

			<div class="mb-4">
				<x-input-label for="xp_awarded" class="text-gray-700" :value="__('XP Awarded')"/>
				<x-text-input id="xp_awarded" type="number" class="block mt-1 w-full" name="xp_awarded" :value="old('xp_awarded', $questLog->xp_awarded)" required/>
				<x-input-error :messages="$errors->get('xp_awarded')" class="mt-2"/>
			</div>

			<div class="mb-4">
				<label for="xp_bonus" class="block text-gray-700 text-sm font-bold mb-2">Bonus XP:</label>
				<input type="number" name="xp_bonus" id="xp_bonus" class="form-input w-full" value="{{ old('xp_bonus', $questLog->xp_bonus) }}">
				@error('xp_bonus')
				<p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
				@enderror
			</div>

			<div class="mb-4">
				<x-input-label for="reviewer_message" class="text-gray-700" :value="__('Reviewer Message')"/>
				<textarea name="reviewer_message" id="reviewer_message" placeholder="Describe how you completed the quest" class="tinymce-full form-textarea w-full" rows="5">{!! $questLog->reviewer_message !!}</textarea>
				<x-input-error :messages="$errors->get('reviewer_message')" class="mt-2 text-red"/>
			</div>

			<x-primary-button>Update Quest Log</x-primary-button>
		</div>
	</div>

</form>