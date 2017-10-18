<?php

namespace App\Services;

use App\Account;
use Auth;

class AccountService
{

    public function account()
	{
		return Account::whereHas('user', function($query) {
                $query->where('id', Auth::user()->id);
            })->get();
	}

    public function card_account()
	{
		return Account::where('account_type', 'card')
            ->whereHas('user', function($query) {
                $query->where('id', Auth::user()->id);
            })->get();
	}

    public function bank_account()
	{
		return Account::where('account_type', 'bank')
            ->whereHas('user', function($query) {
                $query->where('id', Auth::user()->id);
            })->get();
	}
}