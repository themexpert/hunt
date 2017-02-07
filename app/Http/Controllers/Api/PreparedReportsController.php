<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\PreparedReportsRepository;

class PreparedReportsController extends Controller
{
    /**
     * Instance of prepared reports repository.
     *
     * @var PreparedReportsRepository
     */
    protected $preparedReportsRepository;

    /**
     * Create a new instance of prepared reports controller.
     *
     * @param PreparedReportsRepository $preparedReportsRepository
     */
    public function __construct(PreparedReportsRepository $preparedReportsRepository)
    {
        //$this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->preparedReportsRepository = $preparedReportsRepository;
    }

    /**
     * Feature suggestion filter by prepared reports.
     *
     * @param string  $type
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function byType($type, Request $request)
    {
        return $this->responseJson($this->preparedReportsRepository->byType(
            $request->input('limit'),
            $request->input('searchTerms'),
            $request->input('status'),
            $type
        ));
    }
}