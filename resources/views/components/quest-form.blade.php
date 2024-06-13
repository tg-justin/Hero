<div class="grid grid-cols-1 md:grid-cols-1 gap-4">
    <form method="POST" action="{{ $quest ? route('quests.update', $quest->id) : route('quests.store') }}">
        @csrf
        @if($quest)
            @method('PUT')
        @endif
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('title', $quest->title ?? '') }}" required>
            @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>


        <div>
            <div>
                <label for="intro_text" class="block text-sm font-medium text-gray-700">Introduction</label>
                <textarea id="intro_text" name="intro_text" class="mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('intro_text', $quest->intro_text ?? '') !!}</textarea>
                @error('intro_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="accept_text" class="block text-sm font-medium text-gray-700">Accept</label>
                <textarea id="accept_text" name="accept_text" class="mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('accept_text', $quest->accept_text ?? '') !!}</textarea>
                @error('accept_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="directions_text" class="block text-sm font-medium text-gray-700">Directions</label>
                <textarea id="directions_text" name="directions_text" class="mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('directions_text', $quest->directions_text ?? '') !!}</textarea>
                @error('directions_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="complete_text" class="block text-sm font-medium text-gray-700">Complete Text</label>
                <textarea id="complete_text" name="complete_text" class="mt-1 rounded-md shadow-sm focus:ring-seance-500 focus:border-seance-500 h-64">{!! old('complete_text', $quest->complete_text ?? '') !!}</textarea>
                @error('complete_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="bonus_xp_text" class="block text-sm font-medium text-gray-700">Bonus XP</label>
                <textarea id="bonus_xp_text" name="bonus_xp_text" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" rows="5" >{{ old('bonus_xp_text', $quest->bonus_xp_text ?? '') }}</textarea>
                @error('bonus_xp_text')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="min_level" class="block text-sm font-medium text-gray-700">Minimum Level</label>
                <input type="number" name="min_level" id="xp" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="0" value="{{ old('min_level', $quest->min_level ?? '') }}" required>
                @error('min_level')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="xp" class="block text-sm font-medium text-gray-700">XP</label>
                <input type="number" name="xp" id="xp" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" min="1" value="{{ old('xp', $quest->xp ?? '') }}" required>
                @error('xp')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($category->id == old('category_id', $quest->category_id ?? '')) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('start_date', $quest->start_date ?? '') }}">
                @error('start_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="expires_date" class="block text-sm font-medium text-gray-700">Expires Date</label>
                <input type="date" name="expires_date" id="expires_date" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('expires_date', $quest->expires_date ?? '') }}">
                @error('expires_date')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{--
                    <div>
                        <label for="campaign_id" class="block text-sm font-medium text-gray-700">Campaign</label>
                        <select name="campaign_id" id="campaign_id" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Campaign (if applicable)</option>
                            @foreach ($campaigns as $campaign)
                                <option value="{{ $campaign->id }}" @if ($campaign->id == old('campaign_id', $quest->campaign_id ?? '')) selected @endif>{{ $campaign->title }}</option>
                            @endforeach
                        </select>
                    </div>
            --}}



            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mt-4 md:col-span-2">
                    <button type="submit" class="text-white  focus:ring-4  font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">
                        {{ $submitButtonText }}
                    </button>
                </div>
            </div>

            {{--<div>
                <label for="repeatable" class="block text-sm font-medium text-gray-700">Repeatable</label>
                <input type="number" name="repeatable" id="repeatable" class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       min="0"
                       value="{{ old('repeatable', $quest->repeatable ?? 0) }}">
                @error('repeatable')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <small class="text-gray-500">How many times can this quest be repeated? (0 for non-repeatable)</small>
            </div>

            --}}


    </form>
</div>
