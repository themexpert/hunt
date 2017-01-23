<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

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
     * @return Status
     */
    public function all()
    {
        return $this->responseOk([
           'statuses' => config('status')
        ]);
    }
}