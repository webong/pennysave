<?php

namespace App\Http\Controllers;

use Paystack;
use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\TransferException;
use App\Http\Requests\ValidateAccountNumberRequest;
use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;

class PaymentController extends Controller
{

    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function addpayment()
    {
        return view('payment.pay');
    }

    public function paynow()
    {
        request()->reference = Paystack::genTranxRef();
        request()->key = config('paystack.secretKey');
        return Paystack::getAuthorizationUrl()->redirectNow();
    }

    public function handlecallback()
    {
        try {
            $paymentDetails = Paystack::getPaymentData();
        } catch (PaymentVerificationFailedException $e) {
            return redirect('/dashboard')
                ->with('error', 'Error Processing Payment');
        }
        if ($paymentDetails['data']['status'] == 'success') {
            if ($this->paymentService->addDebitingAccount($paymentDetails)) {
                return redirect($paymentDetails['data']['metadata']['referrer'])
                    ->with('success', 'Debiting Account Added Successfully');            
            }
        }
        return redirect($paymentDetails['data']['metadata']['referrer'])
            ->with('error', 'Debiting Account Added Successfully');
    }

    public function resolve_account_number(ValidateAccountNumberRequest $request)
    {
        $url = "https://api.paystack.co/bank/resolve";
        $client = new Client([
            'headers' => [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json'
            ]
        ]);
        $data = [
            "account_number" => $request->account_number,
            "bank_code" => $request->bank_code
        ];
        try {
            $response = $client->get($url, ["query" => $data]);
        } catch (TransferException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            }
        }
        echo $response->getBody()->getContents();
    }

    public function save_account_number(ValidateAccountNumberRequest $request) {
        if ($added = $this->paymentService->addCreditingAccount($request)) {
            return redirect()->back()->with('success', 'Crediting Account Added Successfully');
        }
        return redirect()->back()->with('error', 'Error Adding Crediting Account');
    }
}
