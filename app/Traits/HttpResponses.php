<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses {
    protected function success($data, $code = 200, $message = null): JsonResponse
    {
        return response()->json([
            'status' => 'Request successful',
            'data' => $data,
            'message' => $message
        ], $code);
    }

    protected function error($data, $code, $message = null): JsonResponse
    {
        return response()->json([
            'status' => 'Request failed, please try again',
            'data' => $data,
            'message' => $message
        ], $code);
    }
}
