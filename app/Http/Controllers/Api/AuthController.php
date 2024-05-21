<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponseTrait;


class AuthController extends Controller
{   
    use ApiResponseTrait;
    public function register(UserRegistrationRequest $request)
    {
        // create user data + save
        $validatedData=$request->validated();
        $user=User::create([
        "name" => $validatedData['name'],
        "email" => $validatedData['email'],
        "password" => $validatedData['password'],
        ]);

        if ($user) {
            $token=Auth::guard('api')->tokenById($user->id);
            // $token = JWTAuth::attempt([
            //                     "email" => $request->email,
            //                     "password" => $request->password
            //                    ]);
            return $this->registerResponse(new UserResource($user),$token);
        }

        return $this->errorResponse('User Registration Failed!',500);
    }

    // USER LOGIN API - POST
    public function login(UserLoginRequest $request)
    {    
        // verify user + token
        $validatedData=$request->validated();
        $token = JWTAuth::attempt([
            "email" => $request->safe()->email,
            "password" => $request->safe()->password,
        ]);
        if (!empty($token)) {
            // send response
            return response()->json([
                'success' => true,
                'message' => "User Logged In Succesfully!",
                'data' => [
                    'accessToken' => $token,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => "Invalid credentials",
            'data' => null,
        ],404);
    }
    


    public function refreshToken()
    {
        $newToken=Auth::refresh();
        return response()->json([
            'success' => true,
            'message' => "New access token",
            'data'=> $newToken
        ]);
    }

    // USER LOGOUT API - GET
    public function logout()
    {
        auth()->logout();
        return response()->json([
            'success' => true,
            'message' => "User logged out"
        ]);
    }
}
