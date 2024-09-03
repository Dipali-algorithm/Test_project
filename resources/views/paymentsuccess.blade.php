@extends('layout')

@section('title', 'Payment Success')

@section('content')
    <div class="container mt-4">
        <div class="alert alert-success" role="alert">

            {{-- {{ $orderId }}
            {{ $response['order_id'] }} --}}

        </div>
        <a href="{{ route('home') }}" class="btn btn-primary">Go to Home</a>
    </div>
@endsection
