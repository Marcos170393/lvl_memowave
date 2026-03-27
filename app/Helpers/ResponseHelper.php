<?php
namespace App\Helpers;

class ResponseHelper {
    public static function success($data = [], $status = 200){
        return response()->json($data, $status);
    }
    public static function error($message = 'An error ocurred', $status = 500){
        return response()->json(['error' => $message], $status);
    }
}