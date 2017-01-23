<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\PreparedReportsRepository;

class PreparedReportsController extends Controller
{
    /**
     * Instance of efforts repository.
     *
     * @var PreparedReportsRepository
     */
    protected $preparedReportsRepository;

    /**
     * Create a new instance of statuses controller.
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
            'suggested_features' => $this->preparedReportsRepository->byType($type)
        ]);
    }
}