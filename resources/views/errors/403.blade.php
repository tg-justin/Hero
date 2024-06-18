<x-guest-layout>
    <div class="container mx-auto mt-8">
        <h1 class="text-4xl font-bold text-red-500">403</h1>
        <p class="text-lg mt-4">Halt! This Area is Off-Limits!</p>

        <p>You've ventured into forbidden territory, brave hero. This quest requires a higher level of clearance.</p>
        <p>Perhaps seek guidance from the guildmaster or try a different path?</p>

        <img src="{{ asset('images/error-forbidden.svg') }}" alt="Forbidden Gate" class="w-48 mx-auto mt-4">

        <p class="mt-4"><a href="/" class="text-blue-500 hover:underline">Return to the Tavern</a></p>
    </div>
</x-guest-layout>
