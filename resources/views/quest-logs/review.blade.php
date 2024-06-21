@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Review Quest Log') }}
	</x-slot>

	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			<x-hero-profile :user="$questLog->user"/>
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<h3 class="text-lg font-semibold mb-2">Quest Log Details</h3>
				<p><strong>Quest:</strong> {{ $questLog->quest->title }}</p>
				<p><strong>Accept Text:</strong> {{ $questLog->quest->accept_text }}</p>
				<p><strong>Completed At:</strong> {{ Carbon::parse($questLog->completed_at)->format('d M Y') }}</p>
				<p><strong>Details:</strong> {{ $questLog->completion_details }}</p>
				<h3 class="text-lg font-semibold mt-4 mb-2">Edit Quest Log</h3>

				@include('quest-logs.partials.edit-form')
			</div>
		</div>
	</div>
</x-app-layout>