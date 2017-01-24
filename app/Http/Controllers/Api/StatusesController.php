<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;

class StatusesController extends Controller
{
    /**
     * Create a new instance of statuses controller.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'emailActivation']);
    }

    /**
     * Get all feature statuses.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->responseOk([
           'statuses' => config('status')
        ]);
    }
}