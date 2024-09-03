<h1>Payment</h1>
<form id="razorpay-form" method="post" action="{{ route('payment.response') }}">
    @csrf
    <!-- Hidden inputs for payment details -->
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
    <!-- Add a button to trigger payment -->
    <button id="pay-button">Pay</button>
</form>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    var options = {
        "key": "{{ $data['key'] }}",
        "amount": "{{ $data['amount'] }}",
        "currency": "{{ $data['currency'] }}",
        "name": "{{ $data['name'] }}",
        "description": "{{ $data['description'] }}",
        "image": "{{ $data['image'] }}",
        "order_id": "{{ $data['order_id'] }}",
        "handler": function(response) {
            // Set hidden inputs with payment details
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
            document.getElementById('razorpay_signature').value = response.razorpay_signature;

            // Submit the form
            document.getElementById('razorpay-form').submit();
        },
        "prefill": {
            "name": "{{ $data['prefill']['name'] }}",
            "email": "{{ $data['prefill']['email'] }}",
            "contact": "{{ $data['prefill']['contact'] }}"
        },
        "notes": {
            "address": "{{ $data['notes']['address'] }}"
        },
        "theme": {
            "color": "{{ $data['theme']['color'] }}"
        }
    };

    var paymentObject = new Razorpay(options);

    paymentObject.on('payment.failed', function(response) {
        console.log(response.error.code);
        console.log(response.error.description);
        console.log(response.error.source);
        console.log(response.error.step);
        console.log(response.error.reason);
        console.log(response.error.metadata.order_id);
        console.log(response.error.metadata.payment_id);
        console.log(response);
        window.location.href = "{{ route('payment.failure') }}?order_id=" + encodeURIComponent(
            response.error.metadata.order_id) + "&razorpay_payment_id=" + encodeURIComponent(response.error
            .metadata.payment_id) + "&error_code=" + encodeURIComponent(response.error.code);
    });

    document.getElementById('pay-button').onclick = function(e) {
        e.preventDefault();
        paymentObject.open();
    };
</script>
</body>
