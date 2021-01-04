<?php

namespace App\Http\Services;
use App\Models\Product;

class ProductService
{
    public function getProducts($per_page) {

        $product = Product::withTrashed();

        if($per_page == 0) {
            $product = $product->get();

            return $product;
        }

        $product = $product->paginate($per_page);

        return $product;
    }
}