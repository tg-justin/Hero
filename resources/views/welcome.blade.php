<x-guest-layout>
	<div class="main-outer">
		<div class="main-inner">
			<div class="text-center mb-8"> {{-- Welcome Message Section --}}
				<h1 class="text-4xl md:text-5xl font-bold text-seance-800 mb-4">Welcome Hero!</h1>
				<p class="text-base md:text-lg text-seance-800 text-left">
					Join the Hero program to support Tabletop Gaymers!
					As a volunteer (hero), you complete tasks (quests) from sharing social media posts to organizing events.
					Earn experience points (XP), level up, unlock badges, gain titles, and cool swag.</p>
				<p class="text-lg md:text-xl text-seance-800">
					<strong>Help us create a more inclusive gaming community!</strong>
				</p>
			</div>

			<div class="main-content">
				<h2 class="text-2xl font-bold text-seance-800 mb-4">About Tabletop Gaymers</h2>
				<p class="text-seance-700 text-base">
					We're a passionate group of gamers who believe in creating a safe and inclusive space for everyone to enjoy tabletop role-playing games. Whether you're a seasoned adventurer or new to the world of RPGs, you'll find a
					welcoming community here.
				</p>

				<div class="grid justify-between items-center mt-3 grid-cols-1 md:grid-cols-2">
					<div class="text-center py-6">
						<a href="{{ route('register') }}"
						   class="text-white font-medium text-base bg-seance-700 rounded-lg px-5 py-2.5 hover:text-orange-500 hover:underline-offset-4 hover:bg-seance-800">
							Join the Adventure!
						</a>
					</div>
					<div class="text-center py-3">
						<a href="{{ route('login') }}"
						   class="text-white font-medium text-base bg-seance-700 rounded-lg px-5 py-2.5 hover:text-orange-500 hover:underline-offset-4 hover:bg-seance-800">
							Already a Member?
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</x-guest-layout>