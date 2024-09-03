<form action="{{ route('client.payment.process') }}" method="POST">
    @csrf
    <!-- Form inputs -->
    <input type="hidden" name="razorpay_payment_id" value="pay_OXKBYUOMYsGcpz">
    <input type="hidden" name="status_code" value="200">
    <button type="submit">Submit Payment</button>
</form>
