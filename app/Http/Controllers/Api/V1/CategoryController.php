<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Categories
 *
 * Managing Categories
 */
class CategoryController extends Controller
{
    /**
     * Get Categories
     *
     * List all the categories.
     *
     * @queryParam page Which page to show. Example: 12
     *
     * @response status=200 {
     * "data":[{"id":1,"name":"aut","created_at":"2023-12-01T19:02:42.000000Z"},{"id":2,"name":"nesciunt","created_at":"2023-12-01T19:02:42.000000Z"},{"id":3,"name":"quis","created_at":"2023-12-01T19:02:42.000000Z"}]
     * }
     *
     * @response status=404 {
     * "message": "Not found"
     * }
     *
     */
    public function index()
    {
        // return Category::all();
        // $categories = Category::select('id', 'name', 'created_at')->get();
        // return CategoryResource::collection($categories);

//        if(!auth()->user()->tokenCan('categories-list')) {
//            abort(403, 'Unauthorized');
//        }

        $categories = Category::all();
        return response()->json(['categories' => CategoryResource::collection($categories)]);
    }

    public function show(Category $category)
    {
//        if(!auth()->user()->tokenCan('categories-show')) {
//            abort(403, 'Unauthorized');
//        }

        return new CategoryResource($category);
    }

    /**
     * POST Categories
     *
     * Create new category
     *
     * @bodyParam name string required Name of the category. Example: "Clothing"
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();

        if($request->hasFile('photo')) {
            $file = $request->file('photo');
            $name = 'categories/' . uniqid() . '.' . $file->extension();
            $file->storePubliclyAs('public', $name);
            $data['photo'] = $name;
        }

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    public function update(Category $category, StoreCategoryRequest $request)
    {
        $category->update($request->all());

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
