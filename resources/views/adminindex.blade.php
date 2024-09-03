@extends('layout')

@section('title', 'Create Admin')
@section('content')

    <head>
        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Create New Admin</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($admins as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td>{{ $admin->first_name }}</td>
                        <td>{{ $admin->last_name }}</td>
                        <td>{{ $admin->user_name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            {{-- Display the image --}}
                            <img src="{{ asset('storage/' . $admin->image) }}" alt="Image" width="50">
                        </td>
                        <td>
                            <a href="{{ route('admin.edit', $admin->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
