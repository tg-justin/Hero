@php use Carbon\Carbon; @endphp

<x-app-layout>
	<x-slot name="header">
		{{ __('Hero') }}: {{$hero->name}}
	</x-slot>

	<div class="content-split">

		<div class="content-primary md:order-last">
			<x-hero-profile :user="$hero"/>

			<div class="bg-white px-3 py-1 rounded-md shadow border border-seance-600">
				<table class="stat-block">
					<tr>
						<th>Joined:</th>
						<td>
							<x-date-user-time-zone :value="$hero->created_at" format="d M Y"/>
						</td>
					</tr>
					<tr>
						<th>Last Login:</th>
						<td>
							<x-date-user-time-zone :value="$hero->last_login_at"/>
						</td>
					</tr>
				</table>
			</div>
			@if($viewer->hasRole('manager') || $viewer->hasRole('admin'))
				<x-link-button color="orange" href="#">Reset Password</x-link-button>
				<x-link-button color="orange" href="{{ route('manager.quest-logs', ['user' => $hero->id]) }}">View Quest Log</x-link-button>
			@endif
			@if($hasPermission)
				<div>
					@include('profile.partials.delete-user-button')
				</div>
			@endif

		</div>

		<div class="content-secondary md:order-first">
			<div class="bg-white p-4 rounded-md shadow-inner">
				@if($hasPermission)
					<h2>Account Information</h2>
					@if($self)
						<p class="text-orange-500 text-sm">This information is only visible to you, admins, and managers.<br>
							We will only use this information to notify you of hero-related opportunities.</p>
					@endif

					<table class="stat-block">
						<tr>
							<th>Email:</th>
							<td>
								@if($self)
									<code>{{$hero->email}}</code> (<a href="{{ route('profile.change-email-address') }}">change email</a>)
								@else
									<a href="mailto:{{$hero->email}}">{{$hero->email}}</a>
								@endif
							</td>
						</tr>
						<tr>
							<th>Password:</th>
							<td>
								<code>***************</code>
								@if($self)
									(<a href="{{ route('profile.change-password') }}">change password</a>)
								@endif
							</td>
						</tr>
					</table>
				@endif

				@if($hero->level == 0 && !($viewer->hasRole('manager')) )
					<div class="bg-yellow-200 p-2 text-lg italic text-center">
						Additional profile details are available after you complete your first quest.
					</div>
				@else

					<hr class="mt-8 mb-0"> <!-- PUBLIC INFORMATION ******************************************************* -->
					<div class="flex justify-between items-center">
						<h2>Public Information</h2>
						<span>
						@if($hasPermission)
								<a href="{{ route('profile.edit-public-info', ['heroId' => $hero->id]) }}" class="tg-button-gray">Edit</a>
							@endif
					</span>
					</div>

					@if($self)
						<p class="text-orange-500 text-sm">This information is <strong>visible to other heroes</strong>.<br>
							We may use this information in our promotions and announcements.</p>
					@endif

					<table class="stat-block">
						<tr>
							<th>Hero Name:</th>
							<td>
								{{ $hero->name }}
							</td>
						</tr>
						<tr>
							<th>Location:</th>
							<td>
								<x-default-value :value="$hero->location" default="&mdash;"/>
							</td>
						</tr>
						<tr>
							<th>Profile:</th>
							<td>
								<x-default-value :escape='FALSE' :value="$hero->public_profile" default="&mdash;"/>
							</td>
						</tr>
					</table>

					<hr class="mt-8 mb-0"> <!-- PERSONAL INFORMATION ******************************************************* -->
					@if($hasPermission)
						<div class="flex justify-between items-center">
							<h2>Personal Information</h2>
							<span><a href="{{ route('profile.edit-personal-info', ['heroId' => $hero->id]) }}" class="tg-button-gray">Edit</a></span>
						</div>
						@if($self)
							<p class="text-orange-500 text-sm">This information is only visible to you, admins, and managers.<br>
								We will <strong>not</strong> use this information without your permission.</p>
						@endif

						<table class="stat-block">
							<tr>
								<th>Full Name:</th>
								<td>
									<x-default-value :value="$hero->first_name" default="&mdash;"/>
									<x-default-value :value="$hero->last_name" default="&mdash;"/>
								</td>
							</tr>
							<tr>
								<th>Pronouns:</th>
								<td>
									<x-default-value :value="$hero->pronouns" default="&mdash;"/>
								</td>
							</tr>
							<tr>
								<th>Phone Number:</th>
								<td>
									<x-default-value :value="$hero->phone_number" default="&mdash;"/>
								</td>
							</tr>
							<tr>
								<th>Time Zone:</th>
								<td>
									{{$hero->timezone}}
								</td>
							</tr>
						</table>
					@endif

					@if($hasPermission)
						<hr class="mt-8 mb-0"> <!-- MAILING ADDRESS ******************************************************* -->
						<div class="flex justify-between items-center">
							<h2>Mailing Address</h2>
							<span><a href="{{ route('profile.edit-mailing-address', ['heroId' => $hero->id]) }}" class="tg-button-gray">Edit</a></span>
						</div>

						@if($self)
							<p class="text-orange-500 text-sm">This information is only visible to you, admins, and managers.<br>
								We will only use this information to notify you of regional events or to send you rewards.</p>
						@endif
							<table class="stat-block">
								<tr>
									<th>Mailing Address:</th>
									<td>
										<x-default-value :value="$hero->address" default="&mdash;"/>
										<br>
										<x-default-value :value="$hero->city" default="&mdash;"/>
										<x-default-value :value="$hero->state" default="&mdash;"/>
										<x-default-value :value="$hero->zip_code" default="&mdash;"/>
										<br>
										<x-default-value :value="$hero->country" default="&mdash;"/>
									</td>
								</tr>
							</table>
					@endif
				@endif

			</div>
		</div>
	</div>

</x-app-layout>