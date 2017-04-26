<?php

namespace Hunt\Http\Controllers\Api;

use Illuminate\Http\Request;
use Hunt\Http\Controllers\Controller;
use Hunt\Repositories\ProductsRepository;

class ProductsController extends Controller
{
    /**
     * Instance of products repository.
     *
     * @var ProductsRepository
     */
    protected $productsRepository;

    /**
     * Create a new instance of products controller.
     *
     * @param ProductsRepository $productsRepository
     */
    public function __construct(ProductsRepository $productsRepository)
    {
        $this->middleware(['auth:api', 'emailActivation']);

        $this->productsRepository = $productsRepository;
    }

    /**
     * Add a new product.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
//            'logo' => 'required'
        ]);

        $product = $this->productsRepository->add(
            $request->input('name'),
            $request->input('description'),
            $request->file('logo')
        );

        return $this->responseCreated([
            'product_created' => true,
            'message' => 'New product has been added',
            'product' => $product
        ]);
    }

    /**
     * Get products.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return $this->responseJson($this->productsRepository->get(
            $request->input('limit'),
            $request->input('searchTerms')
        ));
    }

    /**
     * Remove an existing product.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id)
    {
        $this->productsRepository->remove($id);

        return $this->responseOk([
           'message' => 'Product has been deleted'
        ]);
    }

    /**
     * Update an existing product.
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
//            'logo' => 'required'
        ]);

        $this->productsRepository->update(
            $id,
            $request->input('name'),
            $request->input('description'),
            $request->file('logo')
        );

        return $this->responseOk([
            'product_updated' => true,
            'message' => 'Product has been updated'
        ]);
    }

    /**
     * Get a product by the given id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return $this->responseOk([
            'product' => $this->productsRepository->getProductById($id)
        ]);
    }

    /**
     * Get product suggests by the given product id.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggests($id)
    {
        return $this->responseOk([
            'features' => $this->productsRepository->suggests($id)
        ]);
    }
}