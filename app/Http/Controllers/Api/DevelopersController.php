<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\User;
use Hunt\Http\Controllers\Controller;

class DevelopersController extends Controller
{
    /**
     * Create a new instance of statuses controller.
     */
    public function __construct()
    {
        $this->middleware(['auth:api', 'emailActivation', 'dev']);
    }

    /**
     * Get all developers.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return $this->responseOk([
            'developers' => User::developers()
        ]);
    }
}