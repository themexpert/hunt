<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\VotesRepository;

class VotesController extends Controller
{
    /**
     * Instance of votes repository.
     *
     * @var VotesRepository
     */
    protected $votesRepository;

    /**
     * Create a new instance of votes controller.
     *
     * @param VotesRepository $votesRepository
     */
    public function __construct(VotesRepository $votesRepository)
    {
        $this->middleware(['auth:api', 'emailActivation']);

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