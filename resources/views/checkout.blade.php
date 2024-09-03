@extends('layout')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-4">

        @if ($address)
            <div class="mb-4">
                <h4>Delivery Address:</h4>
                <p>
                    {{ $address->address_line1 }},
                    {{ $address->address_line2 }},
                    {{ $address->city }},
                    {{ $address->state }}-
                    {{ $address->postal_code }},
                    {{ $address->country }}<br>
                </p>
            </div>
        @else
            <p>No address selected. Please select an address to proceed.</p>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Shipping Charge</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itemsWithShippingCharges as $itemWithCharge)
                    @php
                        $item = $itemWithCharge['item'];
                        $shippingCharge = $itemWithCharge['shipping_charge'];
                        $itemTotal = $item->product->product_price * $item->quantity + $shippingCharge;
                    @endphp
                    <tr>
                        <td>{{ $item->product->product_name }}</td>
                        <td>{{ number_format($item->product->product_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($shippingCharge, 2) }}</td>
                        <td>{{ number_format($itemTotal, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Subtotal</td>
                    <td>{{ number_format($subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4">Total Shipping Charges</td>
                    <td>{{ number_format($totalShippingCharge, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="font-weight-bold">Order Total</td>
                    <td class="font-weight-bold" style="font-size: 1.25rem; color: #000;">
                        {{ number_format($orderTotal, 2) }}</td>
                </tr>
            </tbody>
        </table>

        @if ($courierDetails)
            <div class="mt-4">
                <h4>Shipping Details:</h4>
                <p><strong>Courier Partner:</strong> {{ $courierDetails['courier_partner'] }}</p>
                <p><strong>Expected Shipping Date:</strong> {{ $courierDetails['expected_shipping_date'] }}</p>

            </div>
        @endif
        @php
            // dd($courierDetails);
        @endphp
        <form action="{{ route('payment.form') }}" method="GET" class="d-inline mt-2">
            @csrf
            <input type="hidden" name="address_id" value="{{ $address->id }}">
            <button type="submit" class="btn btn-primary btn-sm">Place Your Order and Pay</button>
        </form>
    </div>
@endsection
