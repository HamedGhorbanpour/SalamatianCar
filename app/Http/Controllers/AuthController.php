<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $token = $user->createToken('register_token')->plainTextToken;
        return response([
            'user' => $user ,
            'api_token' => $token
        ]);
    }
}
