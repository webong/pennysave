<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Paystack;

class PaymentController extends Controller
{

    public function addpayment()
    {
        return view('payment.pay');
    }

    public function paynow()
    {
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function handlecallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        if ($paymentDetails['data']) {
           $auth_code = $paymentDetails['data']['authorization']['authorization_code'];
        }
        dd($paymentDetails, $paymentDetails['data']['authorization']);
    }
}
