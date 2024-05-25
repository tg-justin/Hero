@extends('layouts.app')

@section('content')
<h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight">Quests</h1>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (Auth::user()->hasRole('quest-master'))

    <a href="{{ route('quests.create') }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800" style="float:right;">Create New Quest</a>
@endif

<table class="w-full text-sm text-left rtl:text-right text-seance-500 dark:text-seance-400" style="width:100%;">
    <thead class="text-xs text-seance-700 uppercase bg-gray-50 dark:bg-seance-700 dark:text-seance-400">
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
        <tr class="bg-white border-b dark:bg-seance-800 dark:border-seance-700">
            <td>{{ $quest->title }}</td>
            <td>{!! Str::limit($quest->description, 50) !!}</td>
            <td>{{ $quest->points }}</td>
            <td>{{ $quest->category->name }}</td>
            @if (Auth::user()->hasRole('quest-master'))
            <td>
                <a href="{{ route('quests.show', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">View</a>
                <a href="{{ route('quests.edit', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Edit</a>
                <form action="{{ route('quests.destroy', $quest->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
