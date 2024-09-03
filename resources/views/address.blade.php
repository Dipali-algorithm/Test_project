<!-- resources/views/address.blade.php -->

@extends('layout')

@section('title', 'Your Addresses')

@section('content')
    <div class="container mt-4">
        <a href="{{ route('client.address.create') }}" class="btn btn-primary mb-3">Add New Address</a>

        @if ($addresses && !$addresses->isEmpty())
            <div class="row">
                @foreach ($addresses as $address)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <p class="card-text">
                                    {{ $address->address_line1 }}<br>
                                    {{ $address->address_line2 }}<br>
                                    {{ $address->city }}<br>
                                    {{ $address->state }}<br>
                                    {{ $address->postal_code }}<br>
                                    {{ $address->country }}<br>
                                    Mobile - {{ $address->mobile }}
                                </p>
                                <form action="{{ route('client.address.destroy', $address->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                </form>
                                {{-- <form action="{{ route('payment.form') }}" method="GET" class="d-inline mt-2">
                                    {{-- @csrf --}}
                                {{-- <input type="hidden" name="address_id" value="{{ $address->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Deliver Here</button>
                                </form>  --}}
                                <form action="{{ route('checkout') }}" method="GET" class="d-inline mt-2">
                                    @csrf
                                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Deliver Here</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No addresses found. Add a new address.</p>
        @endif
    </div>
@endsection
