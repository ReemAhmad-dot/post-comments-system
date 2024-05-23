<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{   
    use ApiResponseTrait;
    public function __construct()
    {
      $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index($post_id)
    {
        $post = Post::find($post_id);
        //$comments = Comment::where('post_id', $post->id)->get();
        if ($post) {
            $comments = Comment::whereBelongsTo($post)->get();
            return $this->successResponse("success",CommentResource::collection($comments));
        }
        return $this->errorResponse();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request,Post $post)
    {
        if($post){
            $comment = $post->comments()->create([
                'body' => $request->safe()->body,
                'user_id' => Auth::id(),
                'post_id' => $post->id,
            ]);
            $data= new CommentResource($comment);
            return $this->successResponse("Comment Created Successfully",$data,201);
        }
        return $this->notFoundResponse("Post Not Found");
    }

    /**
     * Display the specified resource.
     */
    public function show($post_id,Comment $comment)
    {   
       
        if($comment->post_id == $post_id){
            return $this->successResponse("Comment Found",new CommentResource($comment));
        }else{
            return $this->notFoundResponse("Comment Not Found OR something wrong with post");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request,$post_id,Comment $comment)
    {
        if ($comment->post_id == $post_id) {
            if(Auth::Id() === $comment->user_id){
                $comment->update([
                    'body' => $request->safe()->body,
                    'user_id' => Auth::id(),
                    'post_id' => $post_id,
                ]);
                $updatedComment=$comment->refresh();
                return $this->successResponse("Comment updated successfully",new CommentResource($updatedComment),201);
            }else{
                return $this->errorResponse("Action Not Allowed",$statusCode=400);
            }
        return $this->notFoundResponse("Comment Not Found OR something wrong with post");
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id,Comment $comment)
    {
        if($comment){
            if (Auth::Id() === $comment->user_id) {
                $comment->delete();
                return $this->successResponse("Commentt deleted successfully",204);
            }else{
                return $this->errorResponse("Forbidden Action");
            }
        }
        return $this->notFoundResponse("Comment Not Found");
    }
}
