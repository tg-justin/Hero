<x-guest-layout>
	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			<div class="text-center mb-8"> {{-- Welcome Message Section --}}
				<h1 class="text-4xl md:text-5xl font-extrabold text-seance-800 dark:text-seance-800 mb-4">Welcome Hero!</h1>
				<p class="text-md md:text-lg text-seance-800 text-left">
					Join the Hero program to support Tabletop Gaymers!
					As a volunteer (hero), you complete tasks (quests) from sharing social media posts to organizing events.
					Earn experience points (XP), level up, unlock badges, gain titles, and cool swag.</p>
				<p class="text-md md:text-lg text-seance-800 leading-3">
					<strong>Help us create a more inclusive gaming community!</strong>
				</p>
			</div>

			<div class="grid grid-cols-1 md:grid-cols-1 gap-6">
				<div class="bg-white/75 overflow-hidden shadow-xl sm:rounded-lg p-5"> {{-- About Us Section --}}
					<h2 class="text-2xl font-semibold text-seance-800 dark:text-seance-800 mb-4">About Tabletop Gaymers</h2>
					<p class="text-seance-700 dark:text-seance-700">
						We're a passionate group of gamers who believe in creating a safe and inclusive space for everyone to enjoy tabletop role-playing games. Whether you're a seasoned adventurer or new to the world of RPGs, you'll find a
						welcoming community here.
					</p>

					<div class="flex justify-between items-center mt-6">
						<div>
							<a href="{{ route('register') }}"
							   class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">
								Join the Adventure!
							</a>
						</div>
						<div>
							<a href="{{ route('login') }}"
							   class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">
								Already a Member?
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-guest-layout>