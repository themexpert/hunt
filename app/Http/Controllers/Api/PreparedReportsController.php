<?php

namespace Hunt\Http\Controllers\Api;

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
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->preparedReportsRepository = $preparedReportsRepository;
    }

    /**
     * Feature suggestion filter by prepared reports.
     *
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function byType($type)
    {
        return $this->responseOk([
            'features' => $this->preparedReportsRepository->byType($type)
        ]);
    }
}