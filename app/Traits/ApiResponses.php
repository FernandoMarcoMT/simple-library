<?php

namespace App\Traits;

use Illuminate\Http\Exceptions\HttpResponseException;

trait ApiResponses {
    protected function ok($message) {
        return response()->json([
            'message' => $message,
            'status' => 200,
        ]);
    }

    protected function success($message, $data = [], $statusCode = 200){
        return response()->json([
            'message' => $message,
            'status' => $statusCode,
            'data' => $data
        ]);
    }

    protected function error($message, $statusCode){
        throw new HttpResponseException(response([
            "errors" => [
                "message" => [
                    $message
                ],
                "status" => $statusCode
            ]
        ], $statusCode));
    }

}


?>