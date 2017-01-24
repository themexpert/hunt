<?php

namespace Hunt\Concerns;

trait HttpResponse
{
    /**
     * Response unprocessable entity.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseUnprocessableEntity(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 422
        ]), 422);
    }

    /**
     * Response already exist.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseAlreadyExist(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 422,
            'error_code'  => 22
        ]), 422);
    }

    /**
     * Response new item created.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseCreated(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 201
        ]), 201);
    }

    /**
     * Response item not found.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseNotFound(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 404
        ]), 404);
    }

    /**
     * Response ok.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseOk(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 200
        ]), 200);
    }

    /**
     * Response server error.
     *
     * @param array $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseServerError(array $message = [])
    {
        return response()->json(array_merge($message, [
            'status_code' => 500
        ]), 500);
    }

    /**
     * Response json.
     *
     * @param $message
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($message)
    {
        if(! is_array($message)) {
            return $this->responseOk($message->toArray());
        }

        return $this->responseOk($message);
    }
}