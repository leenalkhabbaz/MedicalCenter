<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static function success($data, $statusCode = 200, $message=null)
    {
        return response()->json([
            'status' => true,
            'status_code' => 200,
            'message' => $message,
            'data' => $data,

        ], $statusCode,
     );
    }

    public static function error($message, $statusCode = 400,$status_code=400)
    {
        return response()->json([
            'status' => false,
            'status_code' => $status_code,
            'message' => $message,
            'error' => false
        ], $statusCode);
    }
}

