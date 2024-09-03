@extends('layout')
@section('title')
    User Details
@endsection
@section('content')
    <form class="post-form" action="{{ route('products.store') }}" method="post">
        @csrf
        <div class="form-group">
            <h1>Product</h1>
            <h2>Add New Record</h2>
        </div>
        <div class="form-group">
            <label for="product_name">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required />
        </div>
        <div class="form-group">
            <label for="cid">Category Name</label>
            <select name="cid" id="cid" class="form-control" required>
                <option value="" selected>Select Category Name</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->cid }}"> {{ $category->category_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="product_desc">Product Description</label>
            <input type="text" class="form-control" id="product_desc" name="product_desc" />
        </div>
        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="text" class="form-control" id="product_price" name="product_price" required />
        </div>
        <div class="form-group">
            <label for="product_weight">Product Weight</label>
            <input type="text" class="form-control" id="product_weight" name="product_weight" required />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
