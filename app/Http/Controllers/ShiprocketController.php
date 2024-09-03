<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShiprocketController extends Controller
{
    public function createShipment(Request $request)
    {
        // Environment variables se API key aur endpoint fetch karein
        $apiKey = env('SHIPROCKET_API_KEY');
        $apiEndpoint = env('SHIPROCKET_API_ENDPOINT');

        // Request se dynamic data fetch karna
        $orderId = $request->input('order_id');
        $shipmentMethodId = $request->input('shipment_method_id');
        $deliveryType = $request->input('delivery_type');
        $weight = $request->input('weight');
        $dimensions = $request->input('dimensions'); // Expecting array with keys: length, breadth, height
        $origin = $request->input('origin'); // Expecting array with keys: pincode, state
        $destination = $request->input('destination'); // Expecting array with keys: pincode, state

        // Request payload with dynamic data
        $payload = [
            'order_id' => $orderId,
            'shipment_method_id' => $shipmentMethodId,
            'delivery_type' => $deliveryType,
            'weight' => $weight,
            'dimensions' => [
                'length' => $dimensions['length'] ?? '0',
                'breadth' => $dimensions['breadth'] ?? '0',
                'height' => $dimensions['height'] ?? '0'
            ],
            'origin' => [
                'pincode' => $origin['pincode'] ?? '000000',
                'state' => $origin['state'] ?? 'Unknown'
            ],
            'destination' => [
                'pincode' => $destination['pincode'] ?? '000000',
                'state' => $destination['state'] ?? 'Unknown'
            ]
        ];

        // API request bhejna
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json',
        ])->post($apiEndpoint, $payload);

        // Dynamic response handle karna
        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json([
                'status' => 'success',
                'data' => $responseData
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => $response->body()
            ], $response->status());
        }
    }
}
