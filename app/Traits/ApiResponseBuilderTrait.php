<?php

namespace App\Traits;

trait ApiResponseBuilderTrait
{
    public function response($message, $data = [], $status_code = 200)
    {
        return response()->json([
            'status_code' => $status_code,
            'message' => is_array($message) ? $message : [$message],
            'data' => $data
        ], 200);
    }

    public function retrieve($data)
    {
        return  $this->response(trans('messages.retrieved'), $data);
    }

    public function createdResponse($data)
    {
        return  $this->response(trans('messages.created'), $data);
    }


    public function deleted()
    {
        return  $this->response(trans('messages.deleted'));
    }
}
