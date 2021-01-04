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

    /**
     * get list products
     *
     * @param  Request $request
     * @return Json
     */
    public function index(Request $request)
    {
        $per_page = 25;

        if($request->has('per_page')){
            $per_page = $request->per_page;
        }

        $products = $this->product_service->getProducts($per_page);

        $products = ProductResource::collection($products);

        return response()->json([
            'data' => $products,
            'message' => '',
            'status' => 200,
        ]);
    }

    /**
     * get product
     *
     * @param  Request $request
     * @return Json
     */
    public function show($id)
    {
        $product = $this->product_service->getProduct($id);

        if(!$product) {
            return response()->json([
                'data' => [],
                'message' => __('message.exist', ['field' => 'Product']),
                'status' => 200,
            ]);
        }

        return response()->json([
            'data' => new ProductResource($product),
            'message' => '',
            'status' => 200,
        ]);
    }
}
