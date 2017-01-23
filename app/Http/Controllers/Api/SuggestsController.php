<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SuggestsRepository;

class SuggestsController extends Controller
{
    /**
     * Instance of suggests repository.
     *
     * @var SuggestsRepository
     */
    protected $suggestsRepository;

    /**
     * Create a new instance of suggests controller.
     *
     * @param SuggestsRepository $suggestsRepository
     */
    public function __construct(SuggestsRepository $suggestsRepository)
    {
        $this->middleware('auth:api');

        $this->suggestsRepository = $suggestsRepository;
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

        $this->suggestsRepository->add(
            $request->input('product_id'),
            $request->input('name'),
            $request->input('description'),
            $request->input('is_private'),
            $request->input('tags')
        );

        return $this->responseCreated([
            'suggestion_created' => true,
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
        return $this->responseJson($this->suggestsRepository->get(
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
        $this->suggestsRepository->remove($id);

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

        $this->suggestsRepository->update(
            $id,
            $request->input('name'),
            $request->input('description'),
            $request->input('is_private'),
            $request->input('tags'),
            $request->input('status')
        );

        return $this->responseCreated([
            'suggestion_updated' => true,
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
            'suggested_feature' => $this->suggestsRepository->getFeatureSuggestionById($id)
        ]);
    }
}