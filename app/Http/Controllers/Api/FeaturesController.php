<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Events\NewFeatureRequested;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\FeaturesRepository;

class FeaturesController extends Controller
{
    /**
     * Instance of features repository.
     *
     * @var FeaturesRepository
     */
    protected $featuresRepository;

    /**
     * Create a new instance of features controller.
     *
     * @param FeaturesRepository $featuresRepository
     */
    public function __construct(FeaturesRepository $featuresRepository)
    {
        //$this->middleware(['auth:api', 'emailActivation']);

        $this->featuresRepository = $featuresRepository;
    }

    /**
     * Add a new feature suggestion.
     *
     * @param int     $productId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add($productId, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'is_private' => 'boolean',
            'tags' => 'required|array'
        ]);

        $feature = $this->featuresRepository->add(
            $productId,
            $request->input('name'),
            $request->input('description'),
            $request->input('is_private'),
            $request->input('tags')
        );

        event(new NewFeatureRequested($feature));

        return $this->responseCreated([
            'feature_created' => true,
            'id' => $feature->id,
            'message' => 'New feature suggestion has been added'
        ]);
    }

    /**
     * Get feature suggestions.
     *
     * @param int     $productId
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($productId, Request $request)
    {
        return $this->responseJson($this->featuresRepository->get(
            $request->input('limit'),
            $request->input('searchTerms'),
            $request->input('status'),
            $productId
        ));
    }

    /**
     * Remove an existing feature suggestion.
     *
     * @param int $productId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($productId, $id)
    {
        $this->featuresRepository->remove($productId, $id);

        return $this->responseOk([
           'message' => 'Feature suggestion has been deleted'
        ]);
    }

    /**
     * Update an existing feature suggestion.
     *
     * @param int     $productId
     * @param int     $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($productId, $id, Request $request)
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

        return $this->responseOk([
            'feature_updated' => true,
            'message' => 'Feature suggestion has been updated'
        ]);
    }

    /**
     * Get a feature suggest by the given id.
     *
     * @param int $productId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($productId, $id)
    {
        return $this->responseOk([
            'features' => $this->featuresRepository->getFeatureSuggestionById($productId, $id)
        ]);
    }

    /**
     * Get released features.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function released(Request $request)
    {
        return $this->responseJson($this->featuresRepository->getReleasedFeature(
                $request->input('limit'),
                $request->input('searchTerms'),
                $request->input('status')
        ));
    }
}