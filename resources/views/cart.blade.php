@extends('layout')

@section('title', 'Shopping Cart')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($cartItems->isEmpty())
        <p>Your cart is empty!</p>
        <a href="{{ route('home') }}">Continue Shopping</a>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr id="cart-item-{{ $item->id }}">
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ $item->product->product_price }}</td>
                        <td>
                            <form action="{{ route('client.updateCart', $item->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="input-group" style="max-width: 150px;">
                                    <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}"
                                        min="0" style="width: 60px;">
                                    <button type="submit" class="btn btn-outline-secondary">Update</button>
                                </div>
                            </form>
                        </td>
                        <td class="total-price">{{ $item->product->product_price * $item->quantity }}</td>
                        <td>
                            <form action="{{ route('client.removeFromCart', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">Total</td>
                    <td id="cart-total">{{ $totalPrice }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('home') }}" class="btn btn-primary">Continue Shopping</a>
        <a href="{{ route('client.address') }}" class="btn btn-success">Proceed to Buy</a>
    @endif
@endsection
