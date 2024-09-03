<?php

namespace App\Http\Controllers;

use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;
use Razorpay\Api\Errors\ServerError;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\CartDetail;
use App\Models\Payment;
use App\Models\Address;
use Exception;
use Illuminate\Support\Facades\Http;

class PaymentResponseController extends Controller
{
    protected $razorpayId;
    protected $razorpayKey;

    public function __construct()
    {
        $this->razorpayId = config('services.razorpay.key');
        $this->razorpayKey = config('services.razorpay.secret');
    }

    public function paymentSuccess(Request $request)
    {
        // exit(print_r($_POST, 1));
        return view('paymentsuccess');
    }
}
