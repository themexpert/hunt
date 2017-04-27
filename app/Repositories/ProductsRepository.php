<?php

namespace Hunt\Repositories;

use Hunt\Product;
use Hunt\Concerns\DataWithPagination;

class ProductsRepository
{
    use DataWithPagination;

    /**
     * Add a new product.
     *
     * @param string $name
     * @param string $description
     * @param array  $logo
     * @return \Hunt\Product
     */
    public function add($name, $description, $logo=null)
    {
         $product = Product::create([
             'user_id' => auth('api')->user()->id,
             'name' => $name,
             'description' => $description,
             'logo' => ($logo?$logo->extension():'')
        ]);

        if($logo)
            $logo->storeAs('public/logos', $product->id . '.' . $logo->extension());

        return $product;
    }

    /**
     * Get products.
     *
     * @param int    $limit
     * @param string $searchTerms
     *
     * @return array
     */
    public function get($limit = 10, $searchTerms = '')
    {
        $products = null;

        if(! empty($searchTerms)) {
            $products = Product::where("name", "like", "%$searchTerms%")
                                ->orWhere("description", "like", "%$searchTerms%");
        } else {
            $products = new Product;
        }

        return $this->dataWithPagination($products, $limit);
    }

    /**
     * Remove an existing product.
     *
     * @param int $id
     * @return bool
     */
    public function remove($id)
    {
        $product = Product::findOrFail($id);

        if(empty($product->suggests()->get()->toArray())) {
            @unlink(storage_path("app/public/logos/{$product->id}.{$product->logo}"));

            $product->delete();

            return true;
        }

        return false;
    }

    /**
     * Update an existing feature suggestion.
     *
     * @param int     $id
     * @param string  $name
     * @param string  $description
     * @param array   $logo
     */
    public function update($id, $name, $description, $logo=null)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $name,
            'description' => $description,
            'logo' => ($logo?$logo->extension():'')
        ]);

        if($logo)
            $logo->storeAs('public/logos', $product->id . '.' . $logo->extension());
    }

    /**
     * Get a product by the given product id.
     *
     * @param int $id
     * @return \Hunt\Product
     */
    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    /**
     * Get a product suggests by the given product id.
     *
     * @param int $id
     * @return \Hunt\Product
     */
    public function suggests($id)
    {
        return Product::with('suggests')->findOrFail($id)->suggests;
    }
}