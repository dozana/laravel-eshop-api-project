<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        // return Category::all();
        // $categories = Category::select('id', 'name', 'created_at')->get();
        // return CategoryResource::collection($categories);

        $categories = Category::all();
        return response()->json(['categories' => CategoryResource::collection($categories)]);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }
}
