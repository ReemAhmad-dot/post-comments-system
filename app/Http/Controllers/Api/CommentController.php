<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\PostController;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($post_id,Comment $comment)
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request,$post_id,Comment $comment)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($post_id,Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$post_id,Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id,Comment $comment)
    {
        //
    }
}
