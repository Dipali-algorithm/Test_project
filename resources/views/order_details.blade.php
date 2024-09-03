<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            make payment<div class="cart-body">
                <form action="{{ route('make.payment.form') }}" method="POST">
                    @csrf
                    <div class="'form-group row">
                        <div class="col-lg-10">
                            <p><strong>order id<strong> : {{ $orderid }}</p>
                            <p><strong>amount:<strong>:{{ $razorpayorder->amount }}</p>
                        </div>
                        <button type="submit">pament now </button>

                        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
                        <script>
                            var urls = "{{ route('success') }}"
                            var options = {
                                "key": "rzp_test_7dxulJyEwQLltM", // Enter the Key ID generated from the Dashboard
                                "amount": "{{ $razorpayorder->amount }}", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                                "currency": "INR",
                                "name": "Acme Corp", //your business name
                                "description": "Test Transaction",
                                "image": "https://example.com/your_logo",
                                // "order_id": "{{ $razorpayorder->id }}", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                                "handler": function(response) {
                                    window.location.href = urls + '?payment_id'
                                    // alert(response.razorpay_payment_id);
                                    // alert(response.razorpay_order_id);
                                    // alert(response.razorpay_signature)
                                },
                                "prefill": { //We recommend using the prefill parameter to auto-fill customer's contact information, especially their phone number
                                    "name": "Gaurav Kumar", //your customer's name
                                    "email": "gaurav.kumar@example.com",
                                    "contact": "9000090000" //Provide the customer's phone number for better conversion rates 
                                },
                                "notes": {
                                    "address": "Razorpay Corporate Office"
                                },
                                "theme": {
                                    "color": "#3399cc"
                                }
                            };
                            var rzp1 = new Razorpay(options);
                            rzp1.on('payment.failed', function(response) {
                                alert(response.error.code);
                                alert(response.error.description);
                                alert(response.error.source);
                                alert(response.error.step);
                                alert(response.error.reason);
                                alert(response.error.metadata.order_id);
                                alert(response.error.metadata.payment_id);
                            });
                            document.getElementById('rzp-button1').onclick = function(e) {
                                rzp1.open();
                                e.preventDefault();
                            }
                        </script>
                </form>
</body>

</html>
