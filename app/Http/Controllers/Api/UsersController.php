<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
    /**
     * Instance of users repository.
     *
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware('auth:api');

        $this->usersRepository = $usersRepository;
    }

    /**
     * Get suggested features related then given user id.
     *
     * @param int     $id
     * @return Status
     */
    public function suggests($id)
    {
        return $this->responseOk([
            'suggested_features' => $this->usersRepository->suggests($id)
        ]);
    }
}