<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ config('app.name', 'Hero') }}</title>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=IM+Fell+Double+Pica+SC&display=swap" rel="stylesheet">

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-seance-900 font-['IM Fell Double Pica SC']">
<div class="min-h-screen flex flex-col md:justify-center items-center pt-4">
	<main class="guest">
		<div class="main-inner">

			@if(session('error'))
				<div class="alert-error" role="alert">{!! session('error') !!}</div>
			@endif

			@if(session('warning'))
				<div class="alert-warning" role="alert">{!! session('warning') !!}</div>
			@endif

			@if (session('success'))
				<div class="alert-success" role="alert">{!! session('success') !!}</div>
			@endif

			<div class="main-content text-center underline underline-offset-4 text-orange-600">
				<a href="/">Return to Homepage to Sign-In</a>
			</div>

		</div>
	</main>
</div>
</body>
</html>