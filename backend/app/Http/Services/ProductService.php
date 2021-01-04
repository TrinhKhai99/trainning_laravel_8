<?php

namespace App\Http\Services;
use App\Models\Product;

class ProductService
{
    /**
     * Get list products
     *
     * @param  $per_page
     * @return $object
     */
    public function getProducts($per_page) {

        $products = Product::withTrashed();

        if($per_page == 0) {
            $products = $products->get();

            return $products;
        }

        $products = $products->paginate($per_page);

        return $products;
    }

    /**
     * Get product
     *
     * @param  $id
     * @return $object
     */
    public function getProduct($id) {
        $product = Product::where('id', $id)
            ->withTrashed()
            ->first();

        return $product;
    }
}