<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
<style>
main {
  background-color: #f5f5f5; /* Light gray background */
  font-family: Arial, sans-serif; /* Choose a readable font */
}
p, h1, h2, h3, h4, h5, h6, a {
  color: #333; /* Dark gray text */
}
button, .btn {
  background-color: #4CAF50; /* Green button */
  color: white; /* White text on button */
  border: none; /* Remove default button border */
  padding: 10px 20px; /* Add some padding */
  border-radius: 4px; /* Rounded corners */
  cursor: pointer; /* Indicate clickable element */
}
input, textarea {
  display: block; /* Make them fill the width */
  width: 100%;
  padding: 10px; /* Add some padding */
  border: 1px solid #ccc; /* Add a border */
  border-radius: 4px; /* Rounded corners */
  margin-bottom: 15px; /* Add some spacing */
}

textarea {
  min-height: 100px; /* Set a minimum height for textareas */
}
label {
  display: block; /* Make them appear on new lines */
  margin-bottom: 5px; /* Add some spacing */
  font-weight: bold; /* Make them bolder */
}
button[type="submit"] {
  background-color: #4CAF50; /* Green button */
  color: white; /* White text */
  /* Other button styles from Tailwind */
}

button[type="reset"] {
  background-color: #cccccc; /* Gray button */
  color: #333; /* Dark gray text */
  /* Other button styles from Tailwind */
}
.invalid input,
.invalid textarea {
  border-color: #f00; /* Red border for error */
}

.invalid-feedback {
  display: block;
  color: #f00; /* Red error message */
  margin-top: 5px;
}

</style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
