@extends('layout')

@section('title', 'All Products')

@section('content')
    <a href="{{ route('products.create') }}" class="btn btn-success btn-sm mb-3">Add New Product</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Category Name</th>
                <th>Product Description</th>
                <th>Product Price</th>
                @auth('admin')
                    <th>Product Weight</th>
                @endauth
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->pid }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->category->category_name }}</td>
                    <td>{{ $product->product_desc }}</td>
                    <td>{{ $product->product_price }}</td>
                    @auth('admin')
                        <td>{{ $product->product_weight }}</td>


                        <td>
                            <a href="{{ route('products.edit', $product->pid) }}" class="btn btn-primary btn-sm">Edit</a>
                            <form action="{{ route('products.destroy', $product->pid) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    @else
                        <td>
                            <form action="{{ route('client.addToCart', $product->pid) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                            </form>
                        </td>
                    @endauth
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
