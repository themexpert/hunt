<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\DeclinesRepository;

class DeclinesController extends Controller
{
    /**
     * Instance of declines repository.
     *
     * @var DeclinesRepository
     */
    protected $declinesRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param DeclinesRepository $declinesRepository
     */
    public function __construct(DeclinesRepository $declinesRepository)
    {
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->declinesRepository = $declinesRepository;
    }

    /**
     * Decline an existing feature.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function declineFeature($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|array'
        ]);

        $this->declinesRepository->declineFeature($id, $request->input('status'));

        return $this->responseOk([
           'message' => 'Feature suggestion has been declined'
        ]);
    }
}