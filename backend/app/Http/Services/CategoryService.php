<?php

namespace App\Http\Services;
use App\Models\Category;

class CategoryService {
    /**
     * Get list category
     *
     * @return $object
     */
    public function getCategory() {

        $category = Category::all();

        return $category;
    }
}