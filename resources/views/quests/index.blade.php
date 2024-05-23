@extends('layouts.app')

@section('content')
<h1>Quests</h1>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (Auth::user()->hasRole('quest-master'))
    <a href="{{ route('quests.create') }}" class="btn btn-primary mb-3">Create New Quest</a>
@endif

<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Points</th>
            <th>Category</th>
            @if (Auth::user()->hasRole('quest-master'))
                <th>Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($quests as $quest)
        <tr>
            <td>{{ $quest->title }}</td>
            <td>{!! Str::limit($quest->description, 50) !!}</td>
            <td>{{ $quest->points }}</td>
            <td>{{ $quest->category->name }}</td>
            @if (Auth::user()->hasRole('quest-master'))
            <td>
                <a href="{{ route('quests.show', $quest->id) }}" class="btn btn-sm btn-info">View</a>
                <a href="{{ route('quests.edit', $quest->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('quests.destroy', $quest->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
