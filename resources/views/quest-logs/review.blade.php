@php use Carbon\Carbon; @endphp
<x-app-layout>
	<x-slot name="header">
		{{ __('Review Quest Log') }}
	</x-slot>

	<div class="py-6 bg-cover bg-center">
		<div class="max-w-7xl mx-auto px-2 lg:px-8">
			@if (session('success'))
				<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
					<p class="m-0">{{ session('success') }}</p>
				</div>
			@endif
			<x-hero-profile :user="$questLog->user"/>
			<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
				<h3 class="text-lg font-semibold mb-2">Quest Log Details</h3>
				<p><strong>Quest:</strong> {!! $questLog->quest->title !!}</p>
				<p><strong>Accept Text:</strong> {!! $questLog->quest->accept_text !!}</p>
				<p><strong>Completed At:</strong> {{ Carbon::parse($questLog->completed_at)->format('d M Y') }}</p>
				<p><strong>Time Spent:</strong> {{ floor($questLog->minutes / 60)}} Hours {{$questLog->minutes % 60}} Minutes</p>
				<p>
					<div class="mt-4">
						<h2>Files</h2>
						@if($questLog->files->count() > 0)
							<ul>
								@foreach($questLog->files as $file)
									<li>
										<a href="{{ Storage::url($file->path) }}" target="_blank">{{ $file->title }}</a>
									</li>
								@endforeach
							</ul>
						@else
							<p>No files uploaded.</p>
						@endif
					</div>
				</p>
				<p><strong>Feedback:</strong> {!! $questLog->feedback !!}</p>
				<h3 class="text-lg font-semibold mt-4 mb-2">Edit Quest Log</h3>

				@include('quest-logs.partials.edit-form')
			</div>
		</div>
	</div>
</x-app-layout>