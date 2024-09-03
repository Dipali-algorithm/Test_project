<!-- resources/views/order_tracking.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Order Tracking</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <h1>Order Tracking</h1>


    @if (isset($trackingData['tracking_data']))
        @php
            dd($trackingData['tracking_data']);
        @endphp
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trackingData['tracking_data'] as $event)
                    <tr>
                        <td>{{ $event['date'] }}</td>
                        <td>{{ $event['status'] }}</td>
                        <td>{{ $event['details'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tracking information available.</p>
    @endif

    <a href="{{ route('orders.show') }}">Back to Orders</a>
</body>

</html>
