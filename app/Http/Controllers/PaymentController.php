<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;
use Razorpay\Api\Errors\ServerError;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CartDetail;
use App\Models\Payment;
use App\Models\Order;
use App\Models\Address;
use App\Services\ShiprocketService;
use Illuminate\Support\Facades\DB;
use Exception;

class PaymentController extends Controller
{
    protected $razorpayId;
    protected $razorpayKey;
    protected $shiprocketService;

    public function __construct(ShiprocketService $shiprocketService)
    {
        $this->razorpayId = config('services.razorpay.key');
        $this->razorpayKey = config('services.razorpay.secret');
        $this->shiprocketService = $shiprocketService;
    }

    function generateOrderId($prefix = '224-')
    {
        $counterFile = storage_path('order_counter.txt');

        if (!file_exists($counterFile)) {
            file_put_contents($counterFile, '0');
        }

        $counter = (int) file_get_contents($counterFile);
        $newNumber = $counter + 1;
        file_put_contents($counterFile, (string) $newNumber);

        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function showPaymentForm(Request $request)
    {
        try {
            $client = auth()->guard('client')->user();

            $addressId = $request->session()->get('selected_address_id') ?? $request->input('address_id');
            $address = Address::findOrFail($addressId);
            $productId = $request->input('product_id');
            $product = Products::find($productId);

            $cartItems = CartDetail::where('client_id', $client->id)->get();
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->product_price * $item->quantity;
            });
            $totalShippingCharge = $request->session()->get('total_shipping_charge', 0); // Retrieve from session
            $orderTotal = $totalAmount + $totalShippingCharge;


            $products = $cartItems->map(function ($item) {
                return $item->product->product_name;
            })->implode(', ');
            $productsdetails = $cartItems->map(function ($item) {
                return $item->product->product_desc;
            })->implode(', ');

            $existingOrderId = $request->session()->get('order_id');
            if ($existingOrderId) {
                $order = Order::where('order_id', $existingOrderId)->first();
                if ($order && ($order->order_status === 'pending' || $order->order_status === 'attempted')) {
                    $orderId = $existingOrderId;
                } else {
                    $orderId = $this->createRazorpayOrder($totalAmount, $request);
                }
            } else {
                $orderId = $this->createRazorpayOrder($totalAmount, $request);
            }

            $order = Order::updateOrCreate(
                ['order_id' => $orderId],
                [
                    'client_id' => $client->id,
                    'address_id' => $addressId,
                    'total_payment' => $totalAmount,
                    'order_status' => 'pending',
                    'mobile' => '6353187727',
                    'product_id' => $productId,
                    'shipping_charge' => 50 // Default shipping charge, adjust as needed
                ]
            );

            $data = [
                'key'           => $this->razorpayId,
                'amount'        => $totalAmount * 100,
                'currency'      => 'INR',
                'name'          => 'E-Commerce',
                'description'   => 'Products: ' . $products . ' ' . $productsdetails,
                'image'         => 'https://via.placeholder.com/150x150.png?text=E-Commerce',
                'order_id'      => $orderId,
                'prefill'       => [
                    'name'      => $client->user_name,
                    'email'     => $client->email,
                    'contact'   => $address->mobile,
                ],
                'notes' => [
                    'address' => $address->address_line1 . ', ' . $address->address_line2 . ', ' . $address->city . ', ' . $address->state . ', ' . $address->postal_code . ', ' . $address->country . ', ' . $address->mobile,
                ],
                'theme'         => [
                    'color'     => '#3399cc',
                ],
            ];

            return view('payment', compact('data'));
        } catch (BadRequestError $e) {
            Log::error('Razorpay Bad Request Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong. Please try again.');
        } catch (ServerError $e) {
            Log::error('Razorpay Server Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong on our end. Please try again later.');
        } catch (Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return back()->with('error', 'Something unexpected happened. Please try again.');
        }
    }

    private function createRazorpayOrder($totalAmount, Request $request)
    {
        $api = new Api($this->razorpayId, $this->razorpayKey);
        $razorpayOrder = $api->order->create([
            'receipt'   => 'rcptid_' . time(),
            'amount'    => $totalAmount * 100,
            'currency'  => 'INR',
        ]);
        $orderId = $razorpayOrder['id'];
        $request->session()->put('order_id', $orderId);
        return $orderId;
    }

    public function paymentResponse(Request $request)
    {
        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        try {
            $api = new Api($this->razorpayId, $this->razorpayKey);
            $client = Auth::guard('client')->user();
            $cartItems = CartDetail::where('client_id', $client->id)->get();

            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->product_price * $item->quantity;
            });

            $payment = $api->payment->fetch($paymentId);
            $order = $api->order->fetch($orderId);

            $orderRecord = Order::where('order_id', $orderId)->first();
            if ($orderRecord) {
                $orderRecord->order_status = $order->status;
                $orderRecord->save();

                Payment::updateOrCreate(
                    ['payment_id' => $paymentId],
                    [
                        'payment_status' => $payment->status,
                        'total_payment' => $orderRecord->total_payment,
                        'order_id' => $orderRecord->id,
                    ]
                );

                if ($order->status === 'paid') {
                    CartDetail::where('client_id', $client->id)->delete();
                    $request->session()->forget('order_id');

                    $addressId = $orderRecord->address_id;
                    $address = Address::findOrFail($addressId);

                    $orderID = $this->generateOrderId();
                    $shippingCharge = $orderRecord->shipping_charge;
                    $shiprocketOrderData = [
                        "order_id" => $orderID,
                        "order_date" => now()->toDateTimeString(),
                        "pickup_location" => "Rajkot",
                        "channel_id" => "",
                        "comment" => "Reseller: M/s Goku",
                        "billing_customer_name" => $client->first_name,
                        "billing_last_name" => $client->last_name,
                        "billing_address" => $address->address_line1,
                        "billing_city" => $address->city,
                        "billing_pincode" => $address->postal_code,
                        "billing_state" => $address->state,
                        "billing_country" => $address->country,
                        "billing_email" => $client->email,
                        "billing_phone" => $address->mobile,
                        "shipping_is_billing" => true,
                        "order_items" => [
                            [
                                "name" => $client->first_name,
                                "sku" => $client->user_name,
                                "units" => 10,
                                "selling_price" => 900,
                                "hsn" => 441122
                            ],
                        ],
                        "payment_method" => "Prepaid",
                        "shipping_charges" => $shippingCharge,
                        "giftwrap_charges" => 0,
                        "transaction_charges" => 0,
                        "total_discount" => 0,
                        "sub_total" => $orderRecord->total_payment,
                        "length" => 10,
                        "breadth" => 15,
                        "height" => 20,
                        "weight" => 2.5
                    ];
                    // dd($shippingCharge);
                    $response = $this->shiprocketService->createOrder($shiprocketOrderData);

                    if ($response['status_code'] === 1) {
                        $shippingId = $response['shipment_id'];
                        $orderRecord->shipping_id = $shippingId;
                        $orderRecord->save();

                        return view('paymentsuccess', compact('orderId', 'response'));
                    } else {
                        return redirect()->route('payment.failure')->with('message', 'Order creation failed with Shiprocket.');
                    }
                } else {
                    return redirect()->route('cart')->with('error', 'Payment failed or was cancelled. Please try again.');
                }
            } else {
                return redirect()->route('cart')->with('error', 'Order not found. Please try again.');
            }
        } catch (BadRequestError $e) {
            Log::error('Razorpay Bad Request Error: ' . $e->getMessage());
            return redirect()->route('payment.failure')->with('message', 'Payment failed.');
        } catch (ServerError $e) {
            Log::error('Razorpay Server Error: ' . $e->getMessage());
            return redirect()->route('payment.failure')->with('message', 'Payment failed.');
        } catch (Exception $e) {
            Log::error('General Error: ' . $e->getMessage());
            return redirect()->route('payment.failure')->with('message', 'Payment failed.');
        }
    }


    public function paymentSuccess()
    {
        // This is a public method to show the payment success page
        return view('paymentsuccess')->with('message', session('message'));
    }
    public function paymentFailure(Request $request)
    {
        $paymentId = $request->input('razorpay_payment_id');
        $orderId = $request->input('order_id');
        $errorCode = $request->input('error_code');

        try {
            $api = new \Razorpay\Api\Api($this->razorpayId, $this->razorpayKey);

            // Fetch the order from Razorpay
            $order = $api->order->fetch($orderId);
            // Fetch the order by order_id from your database
            $orderRecord = Order::where('order_id', $orderId)->first();

            if ($orderRecord) {
                // Update the order status to 'failed' or any relevant status
                $orderRecord->order_status = $order->status; // Update status from Razorpay
                $orderRecord->save();

                // Optionally update the payment record with failure details
                Payment::updateOrCreate(
                    ['payment_id' => $request->input('razorpay_payment_id')],
                    [
                        'payment_status' => 'failed',
                        'total_payment' => $orderRecord->total_payment,
                        'order_id' => $orderRecord->id,
                    ]
                );
            }

            // Pass the error code or message to the view
            return view('paymentfailure', [
                'message' => 'Payment failed with error code: ' . $errorCode
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status on payment failure: ' . $e->getMessage());
            return view('paymentfailure', [
                'message' => 'An error occurred while processing your payment.'
            ]);
        }
    }
}
