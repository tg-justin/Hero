@extends('layouts.app')

@section('content')
<h1>Edit Quest</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('quests.update', $quest->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ $quest->title }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" id="description" class="form-control" rows="5" required>{{ $quest->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="points">Points</label>
        <input type="number" name="points" id="points" class="form-control" min="1" required value="{{ $quest->points }}">
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">Select Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @if ($category->id == $quest->category_id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="campaign_id">Campaign (Optional)</label>
        <select name="campaign_id" id="campaign_id" class="form-control">
            <option value="">Select Campaign (if applicable)</option>
            @foreach ($campaigns as $campaign)
                <option value="{{ $campaign->id }}" @if ($campaign->id == $quest->campaign_id) selected @endif>{{ $campaign->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" name="is_repeatable" id="is_repeatable" @if ($quest->is_repeatable) checked @endif>
        <label class="form-check-label" for="is_repeatable">Repeatable</label>
    </div>
    <button type="submit" class="btn btn-primary">Update Quest</button>
</form>

@endsection
