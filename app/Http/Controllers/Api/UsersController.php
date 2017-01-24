<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\UsersRepository;

class UsersController extends Controller
{
    /**
     * Instance of users repository.
     *
     * @var UsersRepository
     */
    protected $usersRepository;

    /**
     * Create a new instance of users controller.
     *
     * @param UsersRepository $usersRepository
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->middleware(['auth:api', 'emailActivation']);

        $this->usersRepository = $usersRepository;
    }

    /**
     * Get suggested features related then given user id.
     *
     * @param int     $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggests($id)
    {
        return $this->responseOk([
            'suggested_features' => $this->usersRepository->suggests($id)
        ]);
    }
}