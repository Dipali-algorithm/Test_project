@extends('layout')
@section('title', 'Edit Admin')
@section('content')

    <head>
        <form action="{{ route('admin.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $admin->first_name }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $admin->last_name }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="{{ $admin->user_name }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="{{ asset('storage/' . $admin->image) }}" alt="Image" width="100" class="mt-2">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
