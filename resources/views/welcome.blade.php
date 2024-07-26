<x-guest-layout>
	<div class="main-content">
		<h1 class="text-4xl md:text-5xl font-bold text-seance-800 mb-4 text-center">Welcome Hero!</h1>
		<p class="text-base md:text-lg text-seance-800 text-left">
			Join the Hero program to support Tabletop Gaymers!
			As a volunteer (hero), you complete tasks (quests) from sharing social media posts to organizing events.
			Earn experience points (XP), level up, unlock badges, gain titles, and cool swag.</p>
		<p class="text-lg md:text-xl text-seance-800 text-center">
			<strong>Help us create a more inclusive gaming community!</strong>
		</p>

		<div class="grid justify-between items-center mt-3 grid-cols-1 md:grid-cols-2">
			<div class="text-center py-3">
				<div><a href="{{ route('register') }}"
						class="text-white font-medium text-base bg-seance-700 rounded-lg px-5 py-2.5 hover:text-orange-500 hover:underline-offset-4 hover:bg-seance-800">
						Join the Adventure!</a>
				</div>
				<div class="text-xs my-2.5">(REGISTER)</div>
			</div>
			<div class="text-center py-3">
				<div><a href="{{ route('sign-in') }}"
						class="text-white font-medium text-base bg-seance-700 rounded-lg px-5 py-2.5 hover:text-orange-500 hover:underline-offset-4 hover:bg-seance-800">
						Already a Member?</a>
				</div>
				<div class="text-xs my-2.5">(SIGN IN)</div>
			</div>
		</div>
	</div>

	<div class="">
		<h2 class="text-xl font-bold text-seance-900">
			Tabletop Gaymers
			<a href="https://tabletopgaymers.org/" target="_blank" class="text-seance-900 hover:text-orange-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5 inline align-baseline">
					<path stroke-linecap="round" stroke-linejoin="round"
						  d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/>
				</svg>
			</a>
		</h2>
		<p class="text-seance-900 text-sm">
			We're a passionate group of gamers who believe in creating a safe and inclusive space for everyone to enjoy tabletop role-playing games. Whether you're a seasoned adventurer or new to the world of RPGs, you'll find a
			welcoming community here.
		</p>
	</div>
</x-guest-layout>