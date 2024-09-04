<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartDetail;
use App\Models\Address;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    public function index()
    {
        $client = Auth::guard('client')->user();
        $addresses = $client->addresses;

        return view('address', compact('addresses'));
    }

    public function create()
    {
        return view('addaddress');
    }

    public function store(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'mobile' => 'required',
        ]);


        Address::create([
            'client_id' => $client->id,
            'address_line1' => $request->address_line1,
            'address_line2' => $request->address_line2,
            'city' => $request->city,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'country' => $request->country,
            'mobile' => $request->mobile,
        ]);

        return redirect()->route('client.address')->with('success', 'Address added successfully.');
    }
    public function destroy($id)
    {
        $address = Address::find($id);
        $address->delete();

        return redirect()->route('client.address')->with('success', 'Address removed successfully.');
    }
    public function deliverToAddress(Request $request)
    {
        try {
            $addressId = $request->input('address_id');
            $products = $request->input('product_id');
            $address = Address::findOrFail($addressId);

            // Set session or use any method to store selected address ID for payment process
            $request->session()->put('selected_address_id', $addressId);
            $request->session()->put('selected_products_id', $products);
            return redirect()->route('payment.form');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    public function checkout(Request $request)
    {
        // Retrieve selected address
        $address = Address::find($request->address_id);

        // Fetch cart items
        $client = Auth::guard('client')->user();
        $cartItems = CartDetail::where('client_id', $client->id)->get();

        // Calculate subtotal
        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->product_price * $item->quantity;
        });

        // Initialize total shipping charge
        $totalShippingCharge = 0;
        $itemsWithShippingCharges = [];

        // Shiprocket API credentials
        $apiToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjQ3NzY1ODAsInNvdXJjZSI6InNyLWF1dGgtaW50IiwiZXhwIjoxNzI1ODgwNTY3LCJqdGkiOiJqa203WUY5b0ljaGVHRDByIiwiaWF0IjoxNzI1MDE2NTY3LCJpc3MiOiJodHRwczovL3NyLWF1dGguc2hpcHJvY2tldC5pbi9hdXRob3JpemUvdXNlciIsIm5iZiI6MTcyNTAxNjU2NywiY2lkIjo0NjEwNTgyLCJ0YyI6MzYwLCJ2ZXJib3NlIjpmYWxzZSwidmVuZG9yX2lkIjowLCJ2ZW5kb3JfY29kZSI6IiJ9.RSciyL4CdwLCIe1AveTaSoP_9vLSFU100fsuy52LZiE'; // Fetch this securely from your environment

        // API endpoint
        $serviceabilityApiUrl = 'https://apiv2.shiprocket.in/v1/external/courier/serviceability/';

        // Prepare request data for Shiprocket
        $requestPayload = [
            'pickup_postcode' => '360024', // Replace with actual pickup postcode
            'delivery_postcode' => $address->postal_code,
            'weight' => $cartItems->sum(function ($item) {
                return $item->product->product_weight * $item->quantity;
            }), // Total weight of all items
            'length' => 15, // Adjust as needed
            'breadth' => 10, // Adjust as needed
            'height' => 5, // Adjust as needed
            'declared_value' => $subtotal, // Total value of all items
            'mode' => 'Surface',
            'is_return' => 0,
            'cod' => 0,
        ];

        // Make API call
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $apiToken,
        ])->get($serviceabilityApiUrl, $requestPayload);

        // Handle API response
        if ($response->failed()) {
            return response()->json([
                'message' => $response->json('message', 'Unknown error'),
                'status_code' => $response->status(),
            ], $response->status());
        }

        $data = $response->json();
        // dd($data);
        // Extract shipping details from the response
        $courierDetails = [];
        foreach ($data['data']['available_courier_companies'] as $courier) {
            if ($courier['courier_name'] === 'India Post-Business Parcel Surface Prepaid') {
                $courierDetails = [
                    'rate' => $courier['rate'],
                    'min_weight' => $courier['min_weight'],
                    'expected_shipping_date' => $courier['etd'] ?? 'N/A',
                    // 'expected_pickup_date' => $courier['expected_pickup_date'] ?? 'N/A',
                    'courier_partner' => $courier['courier_name'],
                    'tracking_link' => $courier['tracking_url'] ?? '#', // Assuming there's a tracking URL
                ];
                break;
            }
        }

        if ($courierDetails) {
            // Calculate shipping charges for each item
            foreach ($cartItems as $item) {
                $weight = $item->product->product_weight; // in kg
                $quantity = $item->quantity;
                $itemWeight = $weight * $quantity;
                $shippingCharge = ($itemWeight >= $courierDetails['min_weight']) ? $courierDetails['rate'] : 1;
                $totalShippingCharge += $shippingCharge;

                // Add item-specific shipping charges to array
                $itemsWithShippingCharges[] = [
                    'item' => $item,
                    'shipping_charge' => $shippingCharge
                ];
            }
        }

        // Calculate order total
        // Calculate order total
        $orderTotal = $subtotal + $totalShippingCharge;

        return view('checkout', compact('address', 'cartItems', 'subtotal', 'orderTotal', 'totalShippingCharge', 'itemsWithShippingCharges', 'courierDetails'));
    }
}
