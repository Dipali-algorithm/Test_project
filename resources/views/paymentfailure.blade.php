@section('title', 'Payment Failed')
@csrf
<h1>Payment Failed</h1>
{{-- <p>{{ $message }}</p> --}}
<a href="{{ route('cart') }}">Return to Cart</a>
