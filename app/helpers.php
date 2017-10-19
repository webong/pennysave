<?php

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use App\MessageAttachment as Attachment;
use Illuminate\Support\HtmlString;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Bank;

if (! function_exists('message')) {
    /**
     * Assign high numeric IDs to a config item to force appending.
     *
     * @param  array  $array
     * @return array
     */
    function apiResMessage($type, $message, $data = NULL, $errorCode = NULL)
    {
        if ($type == 'error') {
            $message = [
                'type' => $type,
                'message' => $message,
            ];
        } else {
            $message = [
                'type' => $type,
                'message' => $message,
                'data' => $data,
            ];
        }

        if (! is_null($errorCode)):
            return response()->json($message, $errorCode);
        else:
            return response()->json($message);
        endif;
    }
}

if (! function_exists('read_more')) {

    function read_more($string, $str_len = 35) {
        // strip tags to avoid breaking any html
        $string = strip_tags($string);

        if (strlen($string) > $str_len) {

            // truncate string
            $stringCut = substr($string, 0, $str_len);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '...';
        }

        return $string;
    }
}

if (! function_exists('gen_uuid')) {

    function gen_uuid() {
        return Uuid::uuid5(Uuid::NAMESPACE_DNS, str_random(20))->toString();
    }
}

if (! function_exists('split_end')) {

    function split_end($url) {
        return array_map('strrev', explode('/', strrev($url), 2));
    }
}

if (! function_exists('check_active')) {

    function check_active($request, $url, $team_id) {
        return (($request == $url) || (split_end($request)[1] == $url) && ($url == url('/teams/' . $team_id . 'messages'))) ? 'active' : null;
    }
}

if (! function_exists('getAttachment')) {

    function getAttachment($attachment_id) {
        return Attachment::find($attachment_id);
    }
}

if (! function_exists('getAttachmentType')) {

    function getAttachmentType($attachment_id) {
        return Attachment::find($attachment_id);
    }
}

if (! function_exists('bg_status')) {

    function bg_status($value) {
        // Not bothering about auto because immediately
        // plan commences, $value becomes active 
        if ($value == 'inactive'): return 'inactive';
        elseif ($value == 'active'): return 'active';
        else: return 'suspended';
        endif;
    }
}

if (! function_exists('confirm_team_status')) {

    function confirm_team_status($value, $start_date) {
        // Return true if active, false if not active
        if ($value == 'inactive'): return false;
        elseif ($value == 'active'): return true;
        elseif ($value == 'auto'):
            if (Carbon::now()->diffInDays($start_date) < 1):
                return true;
            else: return false;
            endif;
        else: return 'suspended';
        endif;
    }
}

if (! function_exists('schedule_date')) {

    function schedule_date($start_date, $recurrence, $added_value) {
        if ($recurrence == 1) {
            return $start_date->addDays($added_value);
        } elseif ($recurrence == 2) {
            return $start_date->addWeeks($added_value);
        } elseif ($recurrence == 3) {
            return $start_date->addWeeks($added_value * 2);
        } elseif ($recurrence == 4) {
            return $start_date->addMonths($added_value);
        }
    }
}

if (! function_exists('get_card_details')) {

    function get_card_details($logo_type, $last_four_digits) {
        if ($logo_type == 'visa DEBIT') {
            $img[] = new HtmlString('<img src="' . asset(urldecode('images%2Fbank%2Fvisa.png')) . '" class="img-rounded img-responsive" />');
            $img[] = 'XXXX XXXX XXXX ' . $last_four_digits;
        } elseif ($logo_type == 'mastercard') {
            $img[] = new HtmlString('<img src="' . asset(urldecode('images%2Fbank%2Fmastercard.png')) . '" class="img-rounded img-responsive" />');
            $img[] = 'XXXX XXXX XXXX ' . $last_four_digits;
        } elseif ($logo_type == 'verve') {
            $img[] = new HtmlString('<img src="' . asset(urldecode('images%2Fbank%2Fverve.png')) . '" class="img-rounded img-responsive" />');
            $img[] = 'XXXXX XXXXX XXXXX ' . $last_four_digits;
        }
        return $img;
    }
}

if (! function_exists('logo_link')) {

    function logo_link($account) {
        if ($account->account_type == 'card') {
            if ($account->type_details == 'visa DEBIT') {
                $img = asset(urldecode('images%2Fbank%2Fvisa.png'));
            } elseif ($account->type_details == 'mastercard') {
                $img = asset(urldecode('images%2Fbank%2Fmastercard.png'));
            } elseif ($account->type_details == 'verve') {
                $img = asset(urldecode('images%2Fbank%2Fverve.png'));
            }
        } else {
            $img = asset(urldecode(Bank::where('code', $account->type_details)->first()->logo));
        }
        return $img;
    }
}

if (! function_exists('account_desc')) {

    function account_desc($account) {
        if ($account->account_type == "bank") {
            $bank = Bank::where('code', $account->type_details)->first();
            $desc = 'Bank Account in ' . $bank->name . ' added ' . $account->created_at->format('l jS F, Y');
        } else {
            $desc = ucwords($account->type_details) . ' ATM card added ' . $account->created_at->format('l jS F, Y');
        }
        return $desc;
    }
}

if (! function_exists('get_bank_name')) {

    function get_bank_name($bank_code) {
        return $bank = Bank::where('code', $bank_code)->first()->name;
    }
}

