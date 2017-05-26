<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\VotesRepository;
use Illuminate\Http\Request;

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
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function up($id, Request $request)
    {
        $this->votesRepository->up($id);

        if($request->wantsJson()) {
            return $this->responseJson(
                [
                    'message' => 'Vote has been accepted'
                ]
            );
        }
        return $this->responseOk([
            'message' => 'Vote has been accepted'
        ]);
    }

    /**
     * Accept feature suggestion down vote.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function down($id, Request $request)
    {
        $this->votesRepository->down($id);

        if($request->wantsJson()) {
            return $this->responseJson(
                [
                    'message' => 'Vote has been accepted'
                ]
            );
        }
        return $this->responseOk([
            'message' => 'Vote has been accepted'
        ]);
    }

    /**
     * Get all up voters.
     *
     * @param int $featureId
     * @return mixed
     */
    public function upVoters($featureId)
    {
        return $this->votesRepository->upVoters($featureId);
    }

    /**
     * Get all down voters.
     *
     * @param int $featureId
     * @return mixed
     */
    public function downVoters($featureId)
    {
        return $this->votesRepository->downVoters($featureId);
    }
}