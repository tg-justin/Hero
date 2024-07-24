<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Hero') }}</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=IM+Fell+Double+Pica+SC&display=swap" rel="stylesheet">

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-seance-900 font-['IM Fell Double Pica SC']">
<div class="min-h-screen flex flex-col md:justify-center items-center pt-4">
	<div>
		<a href="/">
			<x-application-logo class="w-20 h-20 fill-current text-gray-400"/>
		</a>
	</div>

	@if (strpos(config('app.url'), 'stage'))
		<div class="pt-5">
			<div class="w-full md:max-w-screen-md mx-auto">
				<div class="bg-amber-100 overflow-hidden border border-red-600 sm:rounded-lg px-6 py-4">
						<span class="text-rose-700 font-medium text-md"><strong>WARNING:</strong>
							This site is for testing/staging and can change without notice.
							No material or history will be saved or transferred to production.
						</span>
				</div>
			</div>
		</div>
	@endif

	<main class="guest">
		<div class="main-inner">
			{{ $slot }}
		</div>
	</main>
</div>
</body>
</html>