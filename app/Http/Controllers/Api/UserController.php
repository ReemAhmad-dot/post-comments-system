<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{   
    // this is just a note to remmember.

    /**If you’ve been working with Laravel JWT authentication methods for some time
    now you should be familiar with the Auth::user() method for JWT authentication.
    It returns the currently authenticated user using the default guard.
    Considering you’re using a non-default guard, you’ll have to use the Auth::guard() method to specify its name.
    However, if you’ve configured the api guard as default,
    you can skip the call to the Auth::guard() method and write Auth::user() instead.**/

    //Auth::guard('api')->user()
    // but here it will work without it,because middleware 'auth:api' on the route

    // USER PROFILE API - GET
    public function profile()
    {
        $user_data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User profile data",
            "data" => [
                'user' =>$user_data
            ],
        ]);
    }
}
