<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\FeaturesRepository;

class FeaturesController extends Controller
{
    /**
     * Instance of suggests repository.
     *
     * @var FeaturesRepository
     */
    protected $featuresRepository;

    /**
     * Create a new instance of suggests controller.
     *
     * @param FeaturesRepository $featuresRepository
     */
    public function __construct(FeaturesRepository $featuresRepository)
    {
        $this->middleware(['auth:api', 'emailActivation']);

        $this->featuresRepository = $featuresRepository;
    }

    /**
     * Add a new feature suggestion.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|integer',
            'name' => 'required',
            'description' => 'required',
            'is_private' => 'boolean',
            'tags' => 'required|array'
        ]);

        $this->featuresRepository->add(
            $request->input('product_id'),
            $request->input('name'),
            $request->input('description'),
            $request->input('is_private'),
            $request->input('tags')
        );

        return $this->responseCreated([
            'feature_created' => true,
            'message' => 'New feature suggestion has been added'
        ]);
    }

    /**
     * Get feature suggestions.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->responseJson($this->featuresRepository->get(
            $request->input('limit'),
            $request->input('searchTerms')
        ));
    }

    /**
     * Remove feature suggestion.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $this->featuresRepository->remove($id);

        return $this->responseOk([
           'message' => 'Feature suggestion has been deleted'
        ]);
    }

    /**
     * Update an existing feature suggestion.
     *
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'is_private' => 'boolean',
            'tags' => 'required|array',
            'status' => 'required|array'
        ]);

        $this->featuresRepository->update(
            $id,
            $request->input('name'),
            $request->input('description'),
            $request->input('is_private'),
            $request->input('tags'),
            $request->input('status')
        );

        return $this->responseCreated([
            'feature_updated' => true,
            'message' => 'Feature suggestion has been updated'
        ]);
    }

    /**
     * Get a feature suggest by the given id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->responseOk([
            'features' => $this->featuresRepository->getFeatureSuggestionById($id)
        ]);
    }
}