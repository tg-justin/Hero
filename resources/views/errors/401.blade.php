<x-guest-layout>
	<div class="container mx-auto mt-8">
		<h1 class="text-4xl font-bold text-red-500">401</h1>
		<p class="text-lg mt-4">You Shall Not Pass!</p>
		<p>Ah, but this path is not yours to tread, dear traveler. Only those with the proper credentials may
			proceed.</p>
		<p>Perhaps you need to <a href="{{ route('sign-in') }}" class="text-blue-500 hover:underline">prove your
				identity</a> or <a href="{{ route('register') }}" class="text-blue-500 hover:underline">embark on a new
				journey</a>?</p>
		<img src="{{ asset('images/error-gandalf.jpg') }}" alt="Gandalf" class="w-48 mx-auto mt-4">
	</div>
</x-guest-layout>