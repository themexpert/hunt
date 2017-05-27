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
        $this->middleware(['auth:api', 'emailActivation'])->except("index");

        $this->middleware(['auth:api', 'dev'])->only("index");

        $this->usersRepository = $usersRepository;
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return $this->usersRepository->get();
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