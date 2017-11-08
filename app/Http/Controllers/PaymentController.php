<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateAccountNumberRequest;

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
        return $this->paymentService->pay_now();
    }

    public function handlecallback()
    {
        return $this->paymentService->handlecallback();
    }

    public function handlecancelled($team)
    {
        $redirect = config('app.url') . '/teams/' . $team;
        return redirect($redirect)->with('error', 'You Cancelled the Payment');
    }

    public function resolve_account_number(ValidateAccountNumberRequest $request)
    {
        $response = $this->paymentService->resolve_account_number($request);
        echo $response->getBody()->getContents();
    }

    public function save_account_number(ValidateAccountNumberRequest $request, $team_id) {
        if ($added = $this->paymentService->addCreditingAccount($request, $team_id)) {
            return redirect()->back()->with('message', 'Crediting Account Added Successfully');
        }
        return redirect()->back()->with('error', 'Error Adding Crediting Account');
    }
}
