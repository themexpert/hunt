<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\VotesRepository;

class VotesController extends Controller
{
    /**
     * Instance of votes repository.
     *
     * @var VotesRepository
     */
    protected $votesRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param VotesRepository $votesRepository
     */
    public function __construct(VotesRepository $votesRepository)
    {
        $this->middleware('auth:api');

        $this->votesRepository = $votesRepository;
    }

    /**
     * Accept feature suggestion up vote.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function up($id)
    {
        $this->votesRepository->up($id);

        return $this->responseOk([
            'message' => 'Vote has been accepted'
        ]);
    }

    /**
     * Accept feature suggestion down vote.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function down($id)
    {
        $this->votesRepository->down($id);

        return $this->responseOk([
            'message' => 'Vote has been accepted'
        ]);
    }
}