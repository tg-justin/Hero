@extends('layouts.app')

@section('content')
<h1 class="mb-4 pl-6 pt-4 text-4xl font-extrabold leading-none tracking-tight text-seance-900 md:text-5xl lg:text-6xl dark:text-seance-900">Quests</h1>

@if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if (Auth::user()->hasRole('manager'))

    <a href="{{ route('quests.create') }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800" style="float:right;">Create New Quest</a>
@endif
<div class="pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-seance-800 shadow sm:rounded-lg">
            <div class="">

                <table class="w-full text-sm text-left rtl:text-right text-seance-500 dark:text-seance-400" style="width:100%;">
                    <thead class="text-xs text-seance-700 uppercase bg-gray-50 dark:bg-seance-700 dark:text-seance-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Title</th>
                            <th scope="col" class="px-6 py-3">Description</th>
                            <th scope="col" class="px-6 py-3">Points</th>
                            <th scope="col" class="px-6 py-3">Category</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quests as $quest)
                        <tr class="bg-white border-b dark:bg-seance-800 dark:border-seance-700">
                            <td class="px-6 py-4">{{ $quest->title }}</td>
                            <td class="px-6 py-4">{!! Str::limit($quest->description, 50) !!}</td>
                            <td class="px-6 py-4">{{ $quest->points }}</td>
                            <td class="px-6 py-4">{{ $quest->category->name }}</td>
                            @if (Auth::user()->hasRole('manager'))
                            <td class="px-6 py-4">
                                <a href="{{ route('quests.show', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">View</a>
                                <a href="{{ route('quests.edit', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Edit</a>
                                <form action="{{ route('quests.destroy', $quest->id) }}" method="POST" style="display: inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">Delete</button>
                                </form>
                            </td>
                            @elseif(Auth::user()->hasRole('hero'))
                                <td class="px-6 py-4">
                                    <a href="{{ route('quests.show', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800">View</a>
                                </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
