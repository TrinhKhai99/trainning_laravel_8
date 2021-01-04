<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Resources\ProductResource as ProductResource;
use Illuminate\Http\Response as Response;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(ProductService $product_service)
    {
        $this->product_service = $product_service;
    }

    public function index(Request $request)
    {
        $per_page = 25;

        if($request->has('per_page')){
            $per_page = $request->per_page;
        }

        $products = $this->product_service->getProducts($per_page);

        $company_product = ProductResource::collection($products);

        return $company_product;
    }
}
