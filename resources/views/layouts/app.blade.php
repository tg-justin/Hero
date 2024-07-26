<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>
		{{ config('app.name', 'Laravel') }}
		@if (isset($header))
			| {{ $header }}
		@endif
	</title>

	<!-- Fonts -->
	<link href="https://fonts.bunny.net" rel="preconnect">
	<link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
	<link href="/css/tg-button.css" rel="stylesheet"/>

	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

<div class="min-h-0 md:min-h-dvh bg-seance-900 border-gray-500 border-4">
	@include('layouts.navigation')

	<!-- Page Heading -->

	<header class="bg-seance-800 shadow">
		<div class="max-w-7xl mx-auto py-2 px-2 lg:px-8">
			<div class="flex justify-between items-center">
				<span class="header-title">
					@if (isset($header))
						{{ $header }}
					@endif
				</span>
				<span>
					@if (isset($headerRight))
						{{ $headerRight }}
					@endif
				</span>
			</div>
		</div>
	</header>

	@if (session('level_up_message'))
		<x-level-up-notification :message="session('level_up_message')"/>
	@endif

	<main class="h-max">
		<div class="main-inner">

			@if (strpos(config('app.url'), 'stage'))
				<div class="alert-warning text-sm py-1" role="alert">
					<strong>WARNING:</strong>
					This site is for testing/staging and can change without notice. No material or history will be saved or transferred to production.<br>
					<strong>FEEDBACK:</strong>
					Post your feedback, bugs, and suggestions in the HERO &gt;
					<strong><a target="_blank" href="https://discord.com/channels/676797998650359829/1259572186923012206">#hero-feedback</a></strong> channel on
					<strong><a target="_blank" href="https://tabletopgaymers.org/group/discord/">TG Discord</a></strong>.
				</div>
			@endif

			@if(session('error'))
				<div class="alert-error" role="alert">{!! session('error') !!}</div>
			@endif

			@if(session('warning'))
				<div class="alert-warning" role="alert">{!! session('warning') !!}</div>
			@endif

			@if (session('success'))
				<div class="alert-success" role="alert">{!! session('success') !!}</div>
			@endif

{{--			@yield('content')--}}

			@if(isset($slot))
				{{ $slot }}
			@endif

		</div>
	</main>

	<footer>
		@include('layouts.footer')
	</footer>

</div>

</body>
</html>