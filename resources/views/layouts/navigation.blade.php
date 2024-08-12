<nav x-data="{ open: false }" class="bg-seance-800 border-b border-gray-700">
	<!-- Primary Navigation Menu -->
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="flex justify-between h-16">
			<div class="flex">

				{{-- Logo --}}
				<div class="shrink-0 flex items-center">
					<a href="{{ route('quests.index') }}">
						<img src="{{ asset('images/logo.svg') }}" alt="Tabletop Gaymers Logo" class="w-10 h-18 fill-current text-gray-500">
					</a>
				</div>

				{{-- Navigation Links --}}
				<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
					<x-nav-link :href="route('quests.index')" :active="request()->routeIs('quests.index')">
						{{ __('Quest Board') }}
					</x-nav-link>
					@if (Auth::user()->hasRole('hero'))
						{{-- Check for the 'hero' role --}}
						<x-nav-link :href="route('quest-log.index')" :active="request()->routeIs('quest-log.index')">
							{{ __('Quest Log') }}
						</x-nav-link>
					@endif
					@if (Auth::user()->hasRole('manager'))
						{{-- Check for the 'manager' role --}}
						<x-nav-link :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">
							{{ __('Dashboard') }}
						</x-nav-link>
						<x-nav-link :href="route('manager.heroes')" :active="request()->routeIs('manager.heroes')">
							{{ __('Heroes') }}
						</x-nav-link>
						<x-nav-link :href="route('manager.review')" :active="request()->routeIs('manager.review')">
							{{ __('Review') }}
						</x-nav-link>
						<x-nav-link :href="route('report.index')" :active="request()->routeIs('report.index')">
							{{ __('Report') }}
						</x-nav-link>
					@endif
					@if (Auth::user()->hasRole('admin'))
						{{-- Check for the 'admin' role --}}
						<x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
							{{ __('Categories') }}
						</x-nav-link>
						<x-nav-link :href="route('activitylog')" :active="request()->routeIs('activitylog')">
							{{ __('Activity') }}
						</x-nav-link>
						<x-nav-link :href="route('default.styles')" :active="request()->routeIs('default.styles')">
							{{ __('Styles') }}
						</x-nav-link>
					@endif
				</div>
			</div>

			{{-- Settings Dropdown --}}
			<div class="hidden sm:flex sm:items-center sm:ms-6">
				<x-dropdown align="right" width="48">
					<x-slot name="trigger">
						<button class="inline-flex items-center px-1 pt-1
								text-base font-bold
								transition duration-150 ease-in-out
								hover:text-orange-500 focus:text-blue-300 focus:border-blue-700
							 	border-transparent text-orange-300">
							{{ Auth::user()->name }}
							<svg class="ml-1 fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
							</svg>
						</button>
					</x-slot>

					<x-slot name="content">
						<x-dropdown-link :href="route('profile.show-profile-own')">
							{{ __('Profile') }}
						</x-dropdown-link>

						<!-- Authentication -->
						<form method="POST" action="{{ route('logout') }}">
							@csrf
							<input type="hidden" name="_token" id="logout-token" value="{{ csrf_token() }}">
							<x-dropdown-link :href="route('logout')"
											 onclick="event.preventDefault();updateToken();
                                                this.closest('form').submit();">
								{{ __('Sign Out') }}
							</x-dropdown-link>
						</form>
						<script>
							function updateToken() {
								document.getElementById('logout-token').value = '{{ csrf_token() }}';
							}
						</script>
					</x-slot>
				</x-dropdown>
			</div>

			<!-- Hamburger -->
			<div class="-me-2 flex items-center sm:hidden">
				<button @click="open = ! open"
						class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-seance-900 focus:outline-none focus:bg-seance-900 transition duration-150 ease-in-out">
					<svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
						<path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
						<path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
					</svg>
				</button>
			</div>
		</div>
	</div>

	<!-- Mobile Navigation Menu -->
	<div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
		<div class="pt-2 pb-3 space-y-1">
			<x-nav-link :mobile='TRUE' :href="route('quests.index')" :active="request()->routeIs('quests.index')">
				{{ __('Quest Board') }}
			</x-nav-link>
			@if (Auth::user()->hasRole('hero'))
				{{-- Check for the 'hero' role --}}
				<x-nav-link :mobile='TRUE' :href="route('quest-log.index')" :active="request()->routeIs('quest-log.index')">
					{{ __('Quest Log') }}
				</x-nav-link>
			@endif
			@if (Auth::user()->hasRole('manager'))
				{{-- Check for the 'manager' role --}}
				<x-nav-link :mobile='TRUE' :href="route('manager.dashboard')" :active="request()->routeIs('manager.dashboard')">
					{{ __('Dashboard') }}
				</x-nav-link>
				<x-nav-link :mobile='TRUE' :href="route('manager.heroes')" :active="request()->routeIs('manager.heroes')">
					{{ __('Heroes') }}
				</x-nav-link>
				<x-nav-link :mobile='TRUE' :href="route('manager.review')" :active="request()->routeIs('manager.review')">
					{{ __('Review') }}
				</x-nav-link>
				<x-nav-link :mobile='TRUE' :href="route('report.index')" :active="request()->routeIs('report.index')">
					{{ __('Report') }}
				</x-nav-link>
			@endif
			@if (Auth::user()->hasRole('admin'))
				{{-- Check for the 'admin' role --}}
				<x-nav-link :mobile='TRUE' :href="route('categories.index')" :active="request()->routeIs('categories.index')">
					{{ __('Categories') }}
				</x-nav-link>
				<x-nav-link :mobile='TRUE' :href="route('activitylog')" :active="request()->routeIs('activitylog')">
					{{ __('Activity') }}
				</x-nav-link>
				<x-nav-link :mobile='TRUE' :href="route('default.styles')" :active="request()->routeIs('default.styles')">
					{{ __('Styles') }}
				</x-nav-link>
			@endif

		</div>

		<!-- Responsive Settings Options -->
		<div class="pt-4 pb-1 border-t border-seance-600">
			<div class="px-4">
				<div class="font-medium text-base text-seance-200">{{ Auth::user()->name }}</div>
				<div class="font-medium text-sm text-orange-500">{{ Auth::user()->email }}</div>
			</div>

			<div class="mt-3 space-y-1">
				<x-nav-link :mobile='TRUE' :href="route('profile.show-profile-own')" :active="request()->routeIs('profile.show-profile-own')">
					{{ __('Profile') }}
				</x-nav-link>

				<!-- Authentication -->
				<form method="POST" action="{{ route('logout') }}">
					@csrf
					<x-nav-link :mobile='TRUE' :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
						{{ __('Sign Out') }}
					</x-nav-link>
				</form>
			</div>
		</div>
	</div>
</nav>