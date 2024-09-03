<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {

        $client = Auth::guard('client')->user();
        if (!$client) {
            return redirect()->route('login')->with('error', 'You must be logged in to view your orders.');
        }
        $clientId = $client->id;

        $orders = Order::with('product', 'address')
            ->where('client_id', $clientId)
            ->get();

        return view('order', compact('orders'));
    }
    public function trackOrder($shipping_id)
    {
        $apiToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjQ3NzY1ODAsInNvdXJjZSI6InNyLWF1dGgtaW50IiwiZXhwIjoxNzI1ODgwNTY3LCJqdGkiOiJqa203WUY5b0ljaGVHRDByIiwiaWF0IjoxNzI1MDE2NTY3LCJpc3MiOiJodHRwczovL3NyLWF1dGguc2hpcHJvY2tldC5pbi9hdXRob3JpemUvdXNlciIsIm5iZiI6MTcyNTAxNjU2NywiY2lkIjo0NjEwNTgyLCJ0YyI6MzYwLCJ2ZXJib3NlIjpmYWxzZSwidmVuZG9yX2lkIjowLCJ2ZW5kb3JfY29kZSI6IiJ9.RSciyL4CdwLCIe1AveTaSoP_9vLSFU100fsuy52LZiE'; // Fetch this securely from your .env file

        $trackingApiUrl = "https://apiv2.shiprocket.in/v1/external/courier/track/shipment/$shipping_id";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get($trackingApiUrl);

        if ($response->failed()) {
            return response()->json([
                'message' => $response->json('message', 'Unknown error'),
                'status_code' => $response->status(),
            ], $response->status());
        }

        $trackingData = $response->json();
        dd($response);
        dd($trackingData->shipment_track);
        $order = Order::where('shipping_id', $shipping_id)->first();
        return view('order_tracking', compact('trackingData'));
    }
}
