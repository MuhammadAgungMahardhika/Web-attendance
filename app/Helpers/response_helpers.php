<?php

//  response new
if (!function_exists('jsonResponse')) {
    function jsonResponse($data = null,  $code = 200, $message = null,)
    {
        $success = true;
        if ($code == 200) {
            if ($message == null) {
                $message = 'Success getting data';
            }
            $success = true;
        } else if ($code == 201) {
            if ($message == null) {
                $message = "Data created";
            }
        } else if ($code == 500) {
            if ($message == null) {
                $message = 'Internal Server Error!';
            }
            $success = false;
        } else if ($code == 422) {
            if ($message == null) {
                $message = "Unprocesable content!";
            }
            $success = false;
        } else if ($code == 404) {
            if ($message == null) {
                $message = "Data not found!";
            }
            $success = false;
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'code' => $code,
            'timestamp' => now()
        ];

        return response()->json($response, $code);
    }
}
