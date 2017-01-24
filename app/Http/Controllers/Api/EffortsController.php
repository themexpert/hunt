<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\EffortsRepository;

class EffortsController extends Controller
{
    /**
     * Instance of efforts repository.
     *
     * @var EffortsRepository
     */
    protected $effortsRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param EffortsRepository $effortsRepository
     */
    public function __construct(EffortsRepository $effortsRepository)
    {
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->effortsRepository = $effortsRepository;
    }

    /**
     * Update suggested feature development effort value.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'value' => 'required|integer'
        ]);

        $this->effortsRepository->update($id, $request->input('value'));

        return $this->responseOk([
           'message' => 'Suggested feature development effort value updated'
        ]);
    }
}