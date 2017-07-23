<?php

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Http\Request;
use App\MessageAttachment as Attachment;
use Carbon\Carbon;

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
        if ($value == 'inactive'): return false;
        elseif ($value == 'active'): return true;
        elseif ($status == 'auto'):
            if (Carbon::now()->diffInDays($start_date) < 1):
                return true;
            else: return false;
            endif;
        else: return 'suspended';
        endif;
    }
}

