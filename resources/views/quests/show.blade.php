@extends('layouts.app')

@section('content')
<h1>Quest Details</h1>

<div class="card">
    <div class="card-header">
        {{ $quest->title }}
    </div>
    <div class="card-body">
        <p class="card-text">{{ $quest->description }}</p>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Points: {{ $quest->points }}</li>
            <li class="list-group-item">Category: {{ $quest->category->name }}</li>
            @if ($quest->campaign)
                <li class="list-group-item">Campaign: {{ $quest->campaign->title }}</li>
            @endif
            <li class="list-group-item">Repeatable: {{ $quest->is_repeatable ? 'Yes' : 'No' }}</li>
        </ul>
    </div>
</div>

@if (Auth::user()->hasRole('Quest Master'))
    <a href="{{ route('quests.edit', $quest->id) }}" class="btn btn-warning mt-3">Edit Quest</a>
@endif

@endsection
