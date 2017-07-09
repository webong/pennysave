<?php

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
