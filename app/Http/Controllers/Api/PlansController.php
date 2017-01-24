<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\PlansRepository;

class PlansController extends Controller
{
    /**
     * Instance of plans repository.
     *
     * @var PlansRepository
     */
    protected $plansRepository;

    /**
     * Create a new instance of plans controller.
     *
     * @param PlansRepository $plansRepository
     */
    public function __construct(PlansRepository $plansRepository)
    {
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->plansRepository = $plansRepository;
    }

    /**
     * Plan to implement an existing feature.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function planFeature($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|array'
        ]);

        $this->plansRepository->planFeature($id, $request->input('status'));

        return $this->responseOk([
           'message' => 'Feature suggestion has been planed'
        ]);
    }
}