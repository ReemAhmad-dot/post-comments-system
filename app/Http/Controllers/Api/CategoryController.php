<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;

class CategoryController extends Controller
{   
    use ApiResponseTrait;
    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('posts:id,title')
            ->withCount('posts')
            ->latest()
            ->paginate(5);
            return $this->successResponse("success",CategoryResource::collection($categories));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request){
        $request->validated();
        $category=Category::create([
            "name" => $request->name,
        ]);
        if ($category){
            $data=new CategoryResource($category);
            return $this->successResponse("Category Created Successfully",$data,201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category=Category::find($id);
        if($category){
            return $this->successResponse("Category Found",new CategoryResource($category));
            
        }else{
            return $this->notFoundResponse("Category Not Found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {   
        $category=Category::find($id);   //Category::where("id",$id)->exists()
        if($category){
            $category->name=$request->safe()->name ;
            $category->save();
            $category->refresh();

            return $this->successResponse("Category updated successfully",new CategoryResource($category),201);
        }else{
            return $this->notFoundResponse("Category Not Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::find($id);
        if($category){
            $category->delete();
            return $this->successResponse("Category deleted successfully",204);
        }else{
            return $this->notFoundResponse("Category Not Found");
        }
    }
}
