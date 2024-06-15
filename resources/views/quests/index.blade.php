<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-extrabold text-3xl text-seance-200">Quest Board</h2>

            @if (Auth::user()->hasRole('manager'))
                <a href="{{ route('quests.create') }}" class="text-white  focus:ring-4 font-medium rounded-lg text-sm px-5 py-2.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">
                    Create New Quest
                </a>
            @endif
        </div>
    </x-slot>
    <div class="py-12 bg-cover bg-center" >
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            {{-- Display success message --}}
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                    <p class="m-0">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Search and Filter Form --}}
            <div class="mb-4 bg-white p-4 rounded-md shadow-md">
                <form action="{{ route('quests.index') }}" method="GET">
                    <div class="flex items-center space-x-4">
                       {{-- <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category:</label>
                            <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>--}}

                        <div class="flex-grow">
                            <label for="search" class="block text-sm font-medium text-gray-700">Search:</label>
                            <input type="text" name="search" id="search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="Search by title" value="{{ request('search') }}">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-seance-700 hover:bg-seance-800 text-white rounded-md">
                            Search
                        </button>
                    </div>
                </form>
            </div>

            {{-- Quest Table --}}
            <div class="overflow-hidden shadow-xl rounded-lg">
                <table class="min-w-full divide-y divide-seance-200">
                    <thead class="bg-seance-800 text-white">
						<tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                                <a href="{{ route('quests.index', ['sort' => 'level', 'direction' => request('sort') === 'level' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="{{ request('sort') === 'level' ? 'text-yellow-400' : '' }}">
                                    Level
                                    @if (request('sort') === 'level')
                                        <span class="ml-1">
											@if (request('direction') === 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
										</span>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
							<th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
								<a href="{{ route('quests.index', ['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="{{ request('sort') === 'title' ? 'text-yellow-400' : '' }}">
									Quest Title
									@if (request('sort') === 'title')
										<span class="ml-1">
											@if (request('direction') === 'asc')
												<i class="fas fa-sort-up"></i>
											@else
												<i class="fas fa-sort-down"></i>
											@endif
										</span>
									@else
										<i class="fas fa-sort"></i>
									@endif
								</a>
							</th>

							<th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
								<a href="{{ route('quests.index', ['sort' => 'xp', 'direction' => request('sort') === 'xp' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="{{ request('sort') === 'xp' ? 'text-yellow-400' : '' }}">
									XP
									@if (request('sort') === 'xp')
										<span class="ml-1">
											@if (request('direction') === 'asc')
												<i class="fas fa-sort-up"></i>
											@else
												<i class="fas fa-sort-down"></i>
											@endif
										</span>
									@else
										<i class="fas fa-sort"></i>
									@endif
								</a>
							</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider hidden md:table-cell">
                                <a href="{{ route('quests.index', ['sort' => 'expires_date', 'direction' => request('sort') === 'expires_date' && request('direction') === 'asc' ? 'desc' : 'asc'] + request()->except('sort', 'direction')) }}" class="{{ request('sort') === 'expires_date' ? 'text-yellow-400' : '' }}">
                                    Expires
                                    @if (request('sort') === 'xp')
                                        <span class="ml-1">
											@if (request('direction') === 'asc')
                                                <i class="fas fa-sort-up"></i>
                                            @else
                                                <i class="fas fa-sort-down"></i>
                                            @endif
										</span>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
							@if (Auth::user()->hasRole('manager'))
								<th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Actions</th>
							@endif
						</tr>


                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @foreach ($quests as $quest)
                            <tr>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-center text-sm text-slate-600">{{ $quest->min_level }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-800 hover:text-seance-700">
                                    <a href="{{ route('quests.show', $quest->id) }}">
                                        {{ $quest->title }}
                                    </a>
                                </td>

                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $quest->xp }}</td>
                                <td class="hidden md:table-cell px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    @if($quest->expires_date)
                                        {{ \Carbon\Carbon::parse($quest->expires_date)->format('d M Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>


                            @if (Auth::user()->hasRole('manager'))
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('quests.edit', $quest->id) }}" class="text-white  focus:ring-4  font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Edit</a>
                                            <form action="{{ route('quests.destroy', $quest->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white focus:ring-4  font-medium rounded-lg text-sm px-3 py-1.5 bg-seance-600 hover:bg-seance-700 focus:outline-none focus:ring-seance-800">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $quests->appends(request()->except('page'))->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
