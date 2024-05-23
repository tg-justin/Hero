@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="card shadow-sm rounded overflow-hidden">
    <div class="card-header bg-white font-semibold text-xl text-left px-4 py-3 border-b">
      Create Quest
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('quests.store') }}">
        @csrf

        <div class="form-group mb-6">
          <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
          <input type="text" name="title" id="title" class="form-control mt-1 block w-full px-3 py-2 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('title') }}">
          @error('title')
            <span class="invalid-feedback text-red-500 text-xs" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mb-6">
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea name="description" id="description" class="form-control mt-1 block w-full px-3 py-2 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
          @error('description')
            <span class="invalid-feedback text-red-500 text-xs" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mb-6">
          <label for="points" class="block text-sm font-medium text-gray-700">Points</label>
          <input type="number" name="points" id="points" class="form-control mt-1 block w-full px-3 py-2 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('points') }}">
          @error('points')
            <span class="invalid-feedback text-red-500 text-xs" role="alert">
                <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group mb-6">
          <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
          <select name="category_id" id="category_id" class="form-control mt-1 block w-full px-3 py-2 rounded-md bg-white border focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="form-group mb-6">
          <label for="campaign_id" class="block text-sm font-medium text-gray-700">Campaign</label>
          <select name="campaign_id" id="campaign_id" class="form-control mt-1 block w-full px-3 py-2 rounded-md bg-white border focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach ($campaigns as $campaign)
                <option value="{{ $campaign->id }}">{{ $campaign->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="flex justify-end mt-4">
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-500 text-white font-bold rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create Quest
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection