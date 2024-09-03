{{-- resources/views/clientindex.blade.php --}}
@extends('layout')

@section('title', 'Create Client')
@section('content')

    <head>
        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Create New Client</a>
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
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->id }}</td>
                        <td>{{ $client->first_name }}</td>
                        <td>{{ $client->last_name }}</td>
                        <td>{{ $client->user_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $client->image) }}" alt="Image" width="50">
                        </td>
                        <td>
                            <a href="{{ route('client.edit', $client->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('client.destroy', $client->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <a href="{{ route('client.orders', $client->id) }}" class="btn btn-info">View Orders</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @endsection
