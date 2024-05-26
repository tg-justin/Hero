@extends('layouts.app')

@section('content')
<h1 class="mb-4 pl-6 pt-4 text-4xl font-extrabold leading-none tracking-tight text-seance-900 md:text-5xl lg:text-6xl dark:text-seance-900">Quest Details</h1>
<div class="pb-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-seance-800 shadow sm:rounded-lg">
            <div class="">
                <h2 class="text-4xl font-extrabold dark:text-white">{{ $quest->title }}</h2>
                <dl class="max-w-md pb-12 text-seance-900 divide-y divide-seance-200 dark:text-white dark:divide-seance-700">
                    <div class="flex flex-col pb-3">
                        <dt class="mb-1 text-seance-500 md:text-lg dark:text-seance-400">Description</dt>
                        <dd class="text-lg font-semibold">{{ $quest->description }}</dd>
                    </div>
                    <div class="flex flex-col py-3">
                        <dt class="mb-1 text-seance-500 md:text-lg dark:text-seance-400">Points</dt>
                        <dd class="text-lg font-semibold">{{ $quest->points }}</dd>
                    </div>
                    <div class="flex flex-col pt-3">
                        <dt class="mb-1 text-seance-500 md:text-lg dark:text-seance-400">Category</dt>
                        <dd class="text-lg font-semibold">{{ $quest->category->name }}</dd>
                    </div>
                    @if ($quest->campaign)
                        <div class="flex flex-col pt-3">
                            <dt class="mb-1 text-seance-500 md:text-lg dark:text-seance-400">Campaign</dt>
                            <dd class="text-lg font-semibold">{{ $quest->campaign->title }}</dd>
                        </div>
                    @endif
                    <div class="flex flex-col pt-3">
                        <dt class="mb-1 text-seance-500 md:text-lg dark:text-seance-400">Repeatable</dt>
                        <dd class="text-lg font-semibold">{{ $quest->is_repeatable ? 'Yes' : 'No' }}</dd>
                    </div>
                </dl>


            </div>
        </div>
        @if (Auth::user()->hasRole('manager'))
            <a href="{{ route('quests.edit', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800" style="float:right">Edit Quest</a>
        @endif

        @if (Auth::user()->hasRole('hero'))
            <a href="{{ route('quests.edit', $quest->id) }}" class="text-white bg-seance-700 hover:bg-seance-800 focus:ring-4 focus:ring-seance-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-seance-600 dark:hover:bg-seance-700 focus:outline-none dark:focus:ring-seance-800" style="float:right">Accept Quest</a>
        @endif
    </div>
</div>

@endsection
