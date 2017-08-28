<?php

namespace App\Services;

use App\Account;
use App\Bank;
use Auth;

class PaymentService
{
    public function addAccount($account_type, $type, $type_details, $last_four_digit, $auth_token, $status)
    {
        $account = new Account;
        $account->id = gen_uuid();
        $account->user_id = Auth::user()->id;
        $account->account_type = $account_type;
        $account->type = $type;
        $account->type_details = $type_details;
        $account->last_four_digits = $last_four_digit;
        $account->authorization_token = $auth_token;
        $account->status = $status;
        if ($account->save()) {
            return true;
        }
        return false;
    }

    public function addCreditingAccount($request)
    {
        $account_type = 'bank';
        $type = 'crediting';
        $bank_code = $request->bank_code;
        $last_four_digit = substr($request->account_number, -4);
        $auth_token = NULL;
        $status = 'confirmed';
        return $this->addAccount($account_type, $type, $bank_code,
                $last_four_digit, $auth_token, $status);
    }

    public function addDebitingAccount($payment_details)
    {
        $account_type = $payment_details['data']['channel'];
        $type = 'debiting';
        $type_details = $payment_details['data']['authorization']['card_type'];
        $last_four_digit = $payment_details['data']['authorization']['last4'];
        $auth_token = NULL;
        if ($payment_details['data']['authorization']['reusable']) {
            $auth_token = $payment_details['data']['authorization']['authorization_code'];
        }
        $status = 'confirmed';
        return $this->addAccount($account_type, $type, $type_details,
                $last_four_digit, $auth_token, $status);
    }

}