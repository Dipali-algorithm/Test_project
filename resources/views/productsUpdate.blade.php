@extends('layout')
@section('title')
    Update Product
@endsection
@section('content')
    <form class="post-form" action="{{ route('products.update', $products->pid) }}" method="post">
        @csrf
        @method('POST')
        <div class="form-group">
            <h1>Update Product</h1>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name"
                value="{{ $products->product_name }}" required />
        </div>
        <div class="form-group">
            <label for="cid">Category Name</label>
            <select name="cid" id="cid" class="form-control" required>
                <option value="" selected>Select Category Name</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->cid }}" {{ $products->cid == $category->cid ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product_desc">Product Description</label>
            <input type="text" class="form-control" id="product_desc" name="product_desc"
                value="{{ $products->product_desc }}" />
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price"
                value="{{ $products->product_price }}" required />
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
