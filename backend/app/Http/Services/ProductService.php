<?php

namespace App\Http\Services;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ProductService
{
    /**
     * Get list products
     *
     * @param  $per_page
     * @return $object
     */
    public function getProducts($per_page) {

        $products = new Product;

        if($per_page == 0) {
            $products = $products->get();

            return $products;
        }

        $products = $products->paginate($per_page);

        return $products;
    }

    /**
     * search product
     *
     * @param  $params, $per_page
     * @return $object
     */
    public function searchProducts($params, $per_page) {

        $params = array_filter($params, function($value) {
            return $value != null && $value != '';
        });

        $where_query = Arr::only($params, ['entry_date', 'expiration_date', 'page', 'id']);

        $product = Product::where($where_query);

        $product = $product->paginate($per_page);

        return $product;
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

    /**
     * Create or Update Product
     *
     * @param  $product_data
     * @return object
     */
    public function createOrUpdate($product_data) {
        $product = new Product();

        if(!empty($product_data['id'])) {
            $product = Product::where('id', $product_data['id'])->first();
        }

        $product->category_id = $product_data['category_id'];
        $product->name = $product_data['name'];
        $product->image = $product_data['image'];
        $product->amount = $product_data['amount'];
        $product->expiration_date = new Carbon($product_data['expiration_date']);
        $product->entry_date = new Carbon($product_data['entry_date']);
        $product->save();

        return $product;
    }

    /**
     * Validate data
     *
     * @param  $product_data
     * @return Mixed
     */
    public function validate($product_data)
    {
        $validator = Validator::make($product_data, $this->rules($product_data), $this->messages());

        return $validator;
    }

    /**
     * Create array rules for validate
     *
     * @param  $product_data
     * @return $array
     */
    private function rules($product_data)
    {
        $id = 'NULL';

        if(!empty($product_data['id'])){
            $id = $product_data['id'];
        }

        return [
            'name' => 'required|max:512',
            'amount' => 'required|min:0|numeric'
        ];
    }

    /**
     * Create array messages for validate
     *
     * @return $array
     */
    private function messages()
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => 'name']),
            'name.max' => trans('validation.max', ['attribute' => 'name']),
            'amount.min' => trans('validation.min', ['attribute' => 'amount']),
            'amount.numeric' => trans('validation.numeric', ['attribute' => 'amount']),
            'amount.required' => trans('validation.required', ['attribute' => 'amount']),
        ];
    }

    public function deleteProduct($id) {
        $product = Product::where('id', $id)
            ->withTrashed()
            ->first();

        // 1. In case the id cannot be found
        if(!$product) {
            return [];
        }

        if(!$product->trashed()){
            // 2. Delete Product
            try {
                $product->delete();
            } catch(\PDOException $ex) {
                return null;
            }
        }

        return $product;
    }
}