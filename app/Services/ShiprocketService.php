<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShiprocketService
{
    protected $token;
    protected $baseUrl;
    protected $statusUrl;

    public function __construct()
    {
        // Set your Shiprocket API token and base URL
        $this->token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOjQ3NzY1ODAsInNvdXJjZSI6InNyLWF1dGgtaW50IiwiZXhwIjoxNzI1ODgwNTY3LCJqdGkiOiJqa203WUY5b0ljaGVHRDByIiwiaWF0IjoxNzI1MDE2NTY3LCJpc3MiOiJodHRwczovL3NyLWF1dGguc2hpcHJvY2tldC5pbi9hdXRob3JpemUvdXNlciIsIm5iZiI6MTcyNTAxNjU2NywiY2lkIjo0NjEwNTgyLCJ0YyI6MzYwLCJ2ZXJib3NlIjpmYWxzZSwidmVuZG9yX2lkIjowLCJ2ZW5kb3JfY29kZSI6IiJ9.RSciyL4CdwLCIe1AveTaSoP_9vLSFU100fsuy52LZiE";
        $this->baseUrl = 'https://apiv2.shiprocket.in/v1/external/orders/create/adhoc';
        $this->statusUrl = 'https://apiv2.shiprocket.in/v1/external/orders/track'; // Endpoint for tracking
    }

    public function createOrder(array $orderData)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl, $orderData);

        return $response->json();
    }

    public function getOrderStatus($orderId)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ])->get("{$this->statusUrl}/{$orderId}");

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Unable to fetch order status from Shiprocket.');
    }
}
