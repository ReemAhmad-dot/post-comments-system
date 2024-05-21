<?php

namespace App\Http\Controllers\Api;

use {{ namespacedModel }};
use App\Http\Controllers\Controller;
use App\Models\PostController;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostController $postController)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PostController $postController)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, PostController $postController)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PostController $postController, {{ model }} ${{ modelVariable }})
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostController $postController, {{ model }} ${{ modelVariable }})
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostController $postController, {{ model }} ${{ modelVariable }})
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostController $postController, {{ model }} ${{ modelVariable }})
    {
        //
    }
}
