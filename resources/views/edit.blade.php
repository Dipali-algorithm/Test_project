<!-- edit.blade.php -->
@extends('layout')

@section('title', 'Edit Category')

@section('content')
    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category->cid) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="category_name">Category Name</label>
            <input type="text" name="category_name" id="category_name" class="form-control"
                value="{{ $category->category_name }}" required>
        </div>
        <div class="form-group">
            <label for="category_desc">Category Description</label>
            <textarea name="category_desc" id="category_desc" class="form-control">{{ $category->category_desc }}</textarea>
        </div>
        <div class="form-group">
            <label for="parent_id">Parent Category</label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Select Parent Category</option>
                @foreach ($parentCategories as $cat)
                    <option value="{{ $cat->cid }}" @if ($cat->cid == $category->parent_id) selected @endif>
                        {{ str_repeat('--', $cat->level) }} {{ $cat->category_name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
