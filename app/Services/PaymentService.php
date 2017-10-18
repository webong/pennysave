<?php

namespace App\Services;

use App\UserGroup;
use App\Account;
use App\Bank;
use Auth;

class PaymentService
{
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
        $team_id = $paymentDetails['data']['metadata']['custom_fields']['team'];
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