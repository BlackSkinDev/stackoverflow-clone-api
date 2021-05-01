<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class UserController extends Controller
{


    // function for user registration
    public function register(RegisterFormRequest $request){
        $user= User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
       return response()->json([
            'message' => 'Account Created Successfully',
        ], Response::HTTP_OK);

    }

    public function login(LoginFormRequest $request){

        $input = $request->only('email', 'password');
        $jwt_token = null;

        if (!$jwt_token =JWTAuth::attempt($input)) {
            return response()->json([
                'message' => 'Invalid Email or Password',
            ],Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'token' => $jwt_token,
        ],Response::HTTP_OK);
    }





}
