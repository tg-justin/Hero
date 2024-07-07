<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link href="/css/dynamic.css" rel="stylesheet"/>
    <link href="/css/tg-button.css" rel="stylesheet"/>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-seance-900">
    @include('layouts.navigation')

    <!-- Page Heading -->

    <header class="bg-seance-800 shadow">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
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

    <main class="bg-seance-100 mx-auto md:w-4/5 lg:w-80%">
        @if (strpos(config('app.url'), 'stage'))
            <div class="pt-1">
                <div class="max-w-7xl mx-auto px-6 lg:px-8 ">
                    <div class="bg-amber-100 overflow-hidden border border-amber-400 sm:rounded-lg px-4 py-2">
						<div class="text-rose-700 font-medium text-sm"><strong>WARNING:</strong>
							This site is for testing/staging and can change without notice.
							No material or history will be saved or transferred to production.
						</div>
						<div class="text-rose-700 font-medium text-sm"><strong>FEEDBACK:</strong>
							Post your feedback, bugs, and suggestions in the HERO &gt;
							<strong><a target="_blank" href="https://discord.com/channels/676797998650359829/1259572186923012206">#hero-feedback</a></strong>
							channel on
							<strong><a target="_blank" href="https://tabletopgaymers.org/group/discord/">TG Discord</a></strong>.
						</div>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
        @if(isset($slot))
            {{ $slot }}
        @endif
    </main>
</div>

@include('layouts.footer')
</body>
</html>