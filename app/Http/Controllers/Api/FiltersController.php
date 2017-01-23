<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FiltersRepository;

class FiltersController extends Controller
{
    /**
     * Instance of efforts repository.
     *
     * @var FiltersRepository
     */
    protected $filtersRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param FiltersRepository $filtersRepository
     */
    public function __construct(FiltersRepository $filtersRepository)
    {
        $this->middleware('auth:api');

        $this->filtersRepository = $filtersRepository;
    }

    /**
     * Feature suggestion filter by access.
     *
     * @param string $filterBy
     * @return \Illuminate\Http\JsonResponse
     */
    public function byAccess($filterBy)
    {
        return $this->responseOk([
            'suggested_features' => $this->filtersRepository->byAccess($filterBy)
        ]);
    }

    /**
     * Feature suggestion filter by tag.
     *
     * @param int $tagId
     * @return \Illuminate\Http\JsonResponse
     */
    public function byTag($tagId)
    {
        return $this->responseOk([
            'suggested_features' => $this->filtersRepository->byTag($tagId)
        ]);
    }
}