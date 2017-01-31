<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
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
       // $this->middleware(['auth:api', 'emailActivation', 'dev']);

        $this->filtersRepository = $filtersRepository;
    }

    /**
     * Feature suggestion filter by access.
     *
     * @param string  $filterBy
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function byAccess($filterBy, Request $request)
    {
        return $this->responseJson($this->filtersRepository->byAccess(
            $request->input('limit'),
            $request->input('searchTerms'),
            $request->input('status'),
            $filterBy
        ));
    }

    /**
     * Feature suggestion filter by tag.
     *
     * @param int     $tagId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function byTag($tagId, Request $request)
    {
        return $this->responseJson($this->filtersRepository->byTag(
            $request->input('limit'),
            $request->input('searchTerms'),
            $request->input('status'),
            $tagId
        ));
    }
}