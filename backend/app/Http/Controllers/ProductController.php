<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\ProductService;
use App\Http\Resources\ProductResource as ProductResource;
use Illuminate\Http\Response as Response;
use App\Models\Product;
use App\Traits\StorageTrait;

class ProductController extends Controller
{
    use StorageTrait;

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

        return $products;
    }

    /**
     * search products
     *
     * @param  Request $request
     * @return Json
     */
    public function search(Request $request) {
        $per_page = 25;

        if($request->has('per_page')){
            $per_page = $request->per_page;
        }

        $products = $this->product_service->searchProducts($request->all(), $per_page);

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
                'status' => 400,
            ]);
        }

        return response()->json([
            'data' => new ProductResource($product),
            'message' => '',
            'status' => 200,
        ]);
    }

    /**
     * create or update product
     *
     * @param  Request $request
     * @return Json
     */
    public function store(Request $request) {
        $product_data = $request->only([
            "id",
            "category_id",
            "name",
            "image",
            "amount",
            "expiration_date",
            "entry_date",
        ]);

        $validator = $this->product_service->validate($product_data);
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 200,
            ]);
        }

        $product = $this->product_service->createOrUpdate($product_data);

        if(!$product){
            return response()->json([
                'errors' => [trans('message.internal_server_error')],
                'status' => 200,
            ]);
        }

        return response()->json([
            'data' => new ProductResource($product),
            'message' => $product_data['id'] ? __('message.updated', ['field' => 'Product']) : __('message.created', ['field' => 'Product']),
            'status' => 200,
        ]);
    }

    /**
     * delete product
     *
     * @param  Request $request
     * @return Json
     */
    public function destroy($id) {
        $product = $this->product_service->deleteProduct($id);

        return response()->json([
            'data' => new ProductResource($product),
            'message' => __('message.deleted', ['field' => 'Product']),
            'status' => 200,
        ]);
    }

    /**
     * upload file.
     *
     * @param  Request $request
     * @return json
     */
    public function upload(Request $request) {
        if($request->file()) {
            $path = './static/uploads/tmp/';
            $file_upload = $this->uploadFile($request->file('file'), $path);
        }

        return response()->json([
            'data' => $path . $file_upload,
            'message' => __('message.uploaded', ['field' => 'Product']),
            'status' => 200,
        ]);
    }

    private function createDir($dir)
    {
        Storage::disk('public')->makeDirectory($dir);
    }
}
