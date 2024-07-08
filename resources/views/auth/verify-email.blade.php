<x-guest-layout>
	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-6">
			<div class="bg-white/75 overflow-hidden shadow-xl rounded-lg p-4 md:p-6">
				<h2 class="text-2xl font-bold text-seance-800 mb-4">Thanks for Signing Up!</h2>
				<p class="text-seance-700 text-base">
					Before getting started, please verify your email address by clicking on the link we just emailed to you.
					If you didn't receive the email, we will gladly send you another.
				</p>

				@if (session('status') == 'verification-link-sent')
					<div class="my-6 font-medium text-base text-green-600">
						A new verification link has been sent to the email address you provided.
					</div>
				@endif

				<div class="mt-4 flex items-center justify-between">
					<div>
						<form method="POST" action="{{ route('verification.send') }}">
							@csrf
							<x-primary-button>
								{{ __('Resend Verification Email') }}
							</x-primary-button>
						</form>
					</div>
					<form method="POST" action="{{ route('logout') }}">
						@csrf
						<button type="submit"
								class="underline text-base text-gray-600">
							{{ __('Log Out') }}
						</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</x-guest-layout>