<?php

namespace Hunt\Http\Controllers\Api;

use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\FiltersRepository;

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
        $this->middleware(['auth:api', 'emailActivation', 'dev']);

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
            'features' => $this->filtersRepository->byAccess($filterBy)
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
            'features' => $this->filtersRepository->byTag($tagId)
        ]);
    }
}