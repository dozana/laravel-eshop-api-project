<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(9);
        return ProductResource::collection($products);

        //return response()->json(['products' => ProductResource::collection($products)]);
        //return ProductResource::collection($products);
        //return $products;
    }

    public function getProductsByCategory($category_id)
    {
        $products = Product::where('category_id', $category_id)->with('category')->get();

        return response()->json(['products' => ProductResource::collection($products)]);
    }
}
