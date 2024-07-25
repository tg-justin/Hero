@php use Carbon\Carbon; @endphp

<x-app-layout>
	<x-slot name="header">
		{{ __('Hero') }}: {{$hero->name}}
	</x-slot>

	<div class="content-split">

		<div class="content-primary md:order-last">
			<x-hero-profile :user="$hero"/>

			<div class="bg-white px-3 py-1 rounded-md shadow border border-seance-600">
				<div class="flex pb-2">
					<span class="font-bold w-24">Joined:</span>
					<span class="flex-1"><x-date-user-time-zone :value="$hero->created_at" format="d M Y"/></span>
				</div>
				<div class="flex pb-2">
					<span class="font-bold w-24">Last Login:</span>
					<span class="flex-1"><x-date-user-time-zone :value="$hero->last_login_at"/></span>
				</div>
			</div>
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
					<p><strong>Email Address:</strong>
						@if($self)
							<code>{{$hero->email}}</code> (<a href="{{ route('profile.change-email-address') }}">change email</a>)
						@else
							<a href="mailto:{{$hero->email}}">{{$hero->email}}</a>
						@endif
					</p>
					<p><strong>Password:</strong>
						<code>***************</code>
						@if($self)
							(<a href="{{ route('profile.change-password') }}">change password</a>)
						@endif
					</p>
				@endif

				@if($hero->level == 0 && !($viewer->hasRole('manager')) )
					<div class="bg-yellow-200 p-2 text-lg italic text-center">
						Additional profile details are available after you complete your first quest.
					</div>
				@else

					<hr> <!-- PUBLIC INFORMATION ******************************************************* -->
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

					<p><strong>Hero Name:</strong> {{ $hero->name }}</p>
					<p><strong>Location:</strong>
						<x-default-value :value="$hero->location" :default="'<em>not provided</em>'"/>
					</p>
					<p><strong>Profile:</strong></p>
					<div>
						<x-default-value :escape='FALSE' :value="$hero->public_profile" :default="'<p><em>no profile</em></p>'"/>
					</div>


					<hr> <!-- PERSONAL INFORMATION ******************************************************* -->
					@if($hasPermission)
						<hr>
						<div class="flex justify-between items-center">
							<h2>Personal Information</h2>
							<span><a href="{{ route('profile.edit-personal-info', ['heroId' => $hero->id]) }}" class="tg-button-gray">Edit</a></span>
						</div>

						@if($self)
							<p class="text-orange-500 text-sm">This information is only visible to you, admins, and managers.<br>
								We will <strong>not</strong> use this information without your permission.</p>
						@endif

						<p><strong>Full Name:</strong>
							<x-default-value :value="$hero->first_name" :default="'&mdash;'"/>
							<x-default-value :value="$hero->last_name" :default="'&mdash;'"/>
						</p>
						<p><strong>Pronouns:</strong>
							<x-default-value :value="$hero->pronouns" :default="'<em>blank</em>'"/>
						</p>
						<p><strong>Phone Number:</strong>
							<x-default-value :value="$hero->phone_number" :default="'<em>blank</em>'"/>
						</p>
						<p><strong>Time Zone:</strong> {{$hero->timezone}}</p>
					@endif

					@if($hasPermission)
						<hr> <!-- PERSONAL INFORMATION ******************************************************* -->
						<div class="flex justify-between items-center">
							<h2>Mailing Address</h2>
							<span><a href="{{ route('profile.edit-mailing-address', ['heroId' => $hero->id]) }}" class="tg-button-gray">Edit</a></span>
						</div>

						@if($self)
							<p class="text-orange-500 text-sm">This information is only visible to you, admins, and managers.<br>
								We will only use this information to notify you of regional events or to send you rewards.</p>
						@endif

						<p>
							<x-default-value :value="$hero->address" default="&nbsp;"/>
							<br>
							<x-default-value :value="$hero->city" default="&nbsp;"/>
							<x-default-value :value="$hero->state" default="&nbsp;"/>
							<x-default-value :value="$hero->zip_code" default="&nbsp;"/>
							<br>
							<x-default-value :value="$hero->country" default="&nbsp;"/>
						</p>
					@endif





					<p>hero level: {{$hero->level}}</p>
				@endif


			</div>
		</div>
	</div>


	<div class="grid grid-cols-1 md:grid-cols-6 gap-4 mt-10">
		<div class="md:col-span-4 space-y-4">
			<div class="bg-white px-4 py-1 rounded-md shadow-inner">


			</div>
			{{-- CONTENT BODY: END --}}
		</div> {{-- LEFT_COLUMN: END --}}

		<div class="md:col-span-2 space-y-4"> {{-- RIGHT_COLUMN: BEGIN --}}
			<div class="bg-white p-4 rounded-md shadow-inner text-lg text-seance-800"> {{-- STATS: BEGIN --}}
				<p><strong>Level:</strong> {{ $hero->level }}</p>
				<p><strong>Total XP:</strong> {{ $hero->totalxp() }} </p>
				<p><strong>Quests Completed:</strong> {{ $hero->completedQuests()->count() }}</p>
				<p><strong>Joined:</strong>
					{{ Carbon::parse($hero->created_at)->setTimezone($myTimeZone)->format('d M Y (h:i A)') }}
				</p>
				<p><strong>Last Seen:</strong>
					{{ Carbon::parse($hero->last_login_at)->setTimezone($myTimeZone)->format('d M Y (h:i A)') }}
				</p>
			</div> {{-- STATS: END --}}

			@if($viewer->hasRole('manager'))
				<div class="bg-white p-4 rounded-md shadow-inner"> {{-- BUTTONS: BEGIN --}}
					<div class="mx-auto">
						<a href="#" class="tg-button-orange">Password Reset</a>
					</div>
					@if($viewer->hasRole('manager') || $viewer->hasRole('admin'))
						<x-link-button color="purple" href="{{ route('manager.quest-logs', ['user' => $hero->id]) }}">Review Quest Log</x-link-button>
					@endif

				</div>
			@endif
		</div>
	</div>


</x-app-layout>