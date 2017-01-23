<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ReleasesRepository;

class ReleasesController extends Controller
{
    /**
     * Instance of releases repository.
     *
     * @var ReleasesRepository
     */
    protected $releasesRepository;

    /**
     * Create a new instance of statuses controller.
     *
     * @param ReleasesRepository $releasesRepository
     */
    public function __construct(ReleasesRepository $releasesRepository)
    {
        $this->middleware(['auth:api', 'dev']);

        $this->releasesRepository = $releasesRepository;
    }

    /**
     * Release a new feature.
     *
     * @param int     $id
     * @param Request $request
     * @return Status
     */
    public function releaseNewFeature($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required|array'
        ]);

        $this->releasesRepository->makeNewRelease($id, $request->input('status'));

        return $this->responseOk([
           'message' => 'Feature suggestion has been released'
        ]);
    }
}