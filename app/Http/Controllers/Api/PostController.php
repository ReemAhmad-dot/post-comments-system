<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{   use ApiResponseTrait;

    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(5);
        return $this->successResponse("success",PostResource::collection($posts));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //auth()->user()->posts()->save($post);
        $validatedData=$request->validated();
        $post=Post::create([
            "title"=>$validatedData['title'],
            "body"=>$validatedData['body'],
            "user_id"=>Auth::id(),
            "category_id"=> $validatedData['category_id'],
        ]);
        if ($post){
            $data=new PostResource($post);
            return $this->successResponse("Post Created Successfully",$data,201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post=Post::find($id);
        if($post){
            return $this->successResponse("Post Found",new PostResource($post));
            
        }else{
            return $this->notFoundResponse("Post Not Found");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request,Post $post)
    {
        if ($post) {
            if(Auth::Id() === $post->user_id){
                $post->update([
                    "title"=>$request->title ?? $post->title,
                    "body"=>$request->body ?? $post->body,
                    "category_id"=> $request->category_id ?? $post->category_id,
                ]);
                $updatedPost=$post->refresh();
                return $this->successResponse("Post updated successfully",new PostResource($updatedPost),201);
            }else{
                return $this->errorResponse("Action Not Allowed",$statusCode=400);
            }
            return $this->notFoundResponse("Post Not Found");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {   
        if($post){
            if (Auth::Id() === $post->user_id) {
                $post->delete();
                return $this->successResponse("Post deleted successfully",204);
            }else{
                return $this->notFoundResponse("Post Not Found");
            }
        
        return $this->errorResponse("Forbidden Action");
        }
    }
}
