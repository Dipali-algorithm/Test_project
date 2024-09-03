@extends('layout')

@section('title', 'Add Address')

@section('content')

    <form action="{{ route('client.address.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="address_line1">Address Line 1</label>
            <input type="text" name="address_line1" id="address_line1" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="address_line2">Address Line 2</label>
            <input type="text" name="address_line2" id="address_line2" class="form-control">
        </div>
        <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" id="city" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="state">State</label>
            <input type="text" name="state" id="state" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="country">Country</label>
            <input type="text" name="country" id="country" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Address</button>
    </form>
@endsection
