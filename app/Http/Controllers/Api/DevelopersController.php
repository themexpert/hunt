<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;

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
     * @return array
     */
    public function all()
    {
        return $this->responseOk([
            'developers' => User::developers()
        ]);
    }
}