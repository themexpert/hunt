<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\PrioritiesRepository;

class PrioritiesController extends Controller
{
    /**
     * Instance of priorities repository.
     *
     * @var PrioritiesRepository
     */
    protected $prioritiesRepository;

    /**
     * Create a new instance of priorities controller.
     *
     * @param PrioritiesRepository $prioritiesRepository
     */
    public function __construct(PrioritiesRepository $prioritiesRepository)
    {
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->prioritiesRepository = $prioritiesRepository;
    }

    /**
     * Update suggested feature priority value.
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

        $this->prioritiesRepository->update($id, $request->input('value'));

        return $this->responseOk([
           'message' => 'Suggested feature priority value updated'
        ]);
    }
}