<?php
namespace App\Traits;

//use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait{
    protected function apiResponse($success,$message,$data=[],$statusCode=200){
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data'=> $data,
        ],$statusCode);
    }
    
    protected function successResponse($message='success',$data=[],$statusCode=200){
        return $this->apiResponse(true,$message,$data,$statusCode);
    }

    protected function errorResponse($message='Invalid',$statusCode=400){
        return $this->apiResponse(false,$message,null,$statusCode);
    }

    protected function notFoundResponse($message){
        return response()->json([
            'success' => false,
            'message' => $message,
        ],404);
    }
    
    protected function registerResponse($data,$token){
            return response()->json([
                'success' => true,
                'message' => "User registered successfully!",
                'data'=> $data,
                "accessToken" => $token,
                "token_type"=> "Bearer",
            ], 201);
    }
}

