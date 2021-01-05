<?php

namespace App\Http\Controllers;
use App\Http\Services\CategoryService;
use App\Http\Resources\CategoryResource as CategoryResource;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(CategoryService $category_service)
    {
        $this->category_service = $category_service;
    }

    public function index(Request $request)
    {
        $category = $this->category_service->getCategory();

        $category = CategoryResource::collection($category);

        return $category;
    }
}
