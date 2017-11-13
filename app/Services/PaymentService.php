<?php

namespace App\Services;

use Unicodeveloper\Paystack\Exceptions\PaymentVerificationFailedException;
use GuzzleHttp\Exception\TransferException;
use App\Services\UserService;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\UserGroup;
use App\Account;
use Paystack;
use stdClass;
use App\Bank;
use Auth;

class PaymentService
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function pay_now()
    {
        // Confirm that User has set email address
        if ($this->userService->confirmEmailPresent()) {
            return redirect('/profile')->with('message', 'Your Email Needs To Be Set!');
        }
        $user = Auth::user();
        request()->email = $user->email;
        request()->first_name = $user->first_name;
        request()->last_name = $user->last_name;
        request()->amount = 10000; // Convert to Kobo
        request()->metadata = new stdClass();
        request()->metadata->team = request()->team;
        request()->metadata->cancel_action = config('app.url') . '/' . request()->team . '/payment/cancelled';;
        request()->callback_url = config('app.url') . '/payment/callback';
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
            if ($this->addDebitingAccount($paymentDetails)) {
                return redirect($paymentDetails['data']['metadata']['referrer'])
                    ->with('message', 'Debiting Account Added Successfully');            
            }
        }
        return redirect($paymentDetails['data']['metadata']['referrer'])
            ->with('error', 'Error Processing Payment');
    }

    public function resolve_account_number($request)
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
    }

    public function addAccount($account_type, $type, $type_details, $last_four_digit, $auth_token, $status)
    {
        $uuid = gen_uuid();
        $account = new Account;
        $account->id = $uuid;
        $account->user_id = Auth::user()->id;
        $account->account_type = $account_type;
        $account->type = $type;
        $account->type_details = $type_details;
        $account->last_four_digits = $last_four_digit;
        $account->authorization_token = $auth_token;
        $account->status = $status;
        if ($account->save()) {
            return $uuid;
        }
        return false;
    }

    public function addCreditingAccount($request, $team_id)
    {
        $account_type = 'bank';
        $type = 'crediting';
        $bank_code = $request->bank_code;
        $last_four_digit = substr($request->account_number, -4);
        $auth_token = NULL;
        $status = 'confirmed';
        if ($account_id = $this->addAccount($account_type, $type, $bank_code,
                $last_four_digit, $auth_token, $status)) {
            return $this->paymentAccount($type, $account_id, $team_id);
        }
    }

    public function addDebitingAccount($payment_details)
    {
        $account_type = $payment_details['data']['channel'];
        $type = 'debiting';
        $team_id = $payment_details['data']['metadata']['team'];
        $type_details = $payment_details['data']['authorization']['card_type'];
        $last_four_digit = $payment_details['data']['authorization']['last4'];
        $auth_token = NULL;
        if ($payment_details['data']['authorization']['reusable']) {
            $auth_token = $payment_details['data']['authorization']['authorization_code'];
        }
        $status = 'confirmed';
        if ($account_id = $this->addAccount($account_type, $type, $type_details,
                $last_four_digit, $auth_token, $status)) {
            return $this->paymentAccount($type, $account_id, $team_id);
        }
    }

    public function addPaymentAccount($request, $team_id)
    {
        $type = ($request->save_account == 'credit-account') ? 'crediting' : 'debiting';
        return $this->paymentAccount($type, $request->bank_code, $team_id);
    }

    public function paymentAccount($type, $account, $team_id)
    {
        $userGroup = UserGroup::where('group_id', $team_id)
            ->where('user_id', Auth::user()->id)
            ->update([ $type => $account ]);
        if ($userGroup) {
            return true;
        }
        return false;
    }
}