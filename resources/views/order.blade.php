@extends('layout')

@section('title', 'All Orders')

@section('content')
    <div class="container my-4">
        <div class="row">
            @foreach ($orders as $order)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">Order #{{ $order->id }}</h5>
                        </div>
                        <div class="card-body">
                            @if ($order->products)
                                <h6 class="card-title">Product Details</h6>
                                <p><strong>Product Name:</strong> {{ $order->product->product_name }}</p>
                                <p><strong>Product Price:</strong> {{ number_format($order->product->product_price, 2) }}
                                </p>
                                <p><strong>Description:</strong> {{ $order->product->product_desc }}</p>
                            @else
                                <p>No product information available.</p>
                            @endif

                            <h6 class="card-title mt-3">Shipping Address</h6>
                            <p><strong>Address:</strong>
                                {{ $order->address->address_line1 }},
                                {{ $order->address->address_line2 }},
                                {{ $order->address->city }},
                                {{ $order->address->state }},
                                {{ $order->address->postal_code }},
                                {{ $order->address->country }},
                                {{ $order->address->mobile }}
                            </p>

                            <p><strong>Total Payment:</strong> {{ number_format($order->total_payment, 2) }}</p>
                            <p><strong>Shipping ID:</strong> {{ $order->shipping_id }}</p>
                            @php
                                $id = $order->shipping_id;
                            @endphp
                            <a href="{{ route('order.track', $id) }}">Track Order</a>


                        </div>
                        <div class="card-footer text-muted">
                            <small>Order placed on {{ $order->created_at->format('d M Y, h:i A') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
