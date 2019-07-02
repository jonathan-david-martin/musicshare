<?php

namespace App\Traits;

trait PreparesJSONResponses
{
    public function respond($data, $statusCode = 200)
    {
        return response()->json($data, $statusCode);
    }

    public function respondWithError($message, $statusCode = 200, $detail = 'No details')
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $statusCode
                ]
            ], $statusCode);
    }

    public function respondWithData($data, $statusCode = 200)
    {
        return $this->respond([
            'payload' => $data
        ]);
    }
}