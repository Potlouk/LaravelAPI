<?php

namespace App\Traits;

trait ApiResponse
{
    public static function response($data, $code = 200) {
        return response()->json(
            $data
      , $code);
    }

    public static function respondSuccess($message = 'Done!', $code = 200) {
        return response()->json([
            'message' => $message
        ], $code);
    }

    public static function respondWithError($message = 'Server error', $code = 500) {
        return response()->json([
            'message' => $message
        ], $code);
    }
    
    public static function respondWithPages($pages) {
        return response()->json([
            'total' => $pages->total(),
            'lastPage' => $pages->lastPage(),
            'data' => $pages->items()], 200);
    }
}
