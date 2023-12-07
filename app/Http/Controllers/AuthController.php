<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
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
            'token' => $token
        ]);
    }
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt(['email'=>$request->email , 'password'=>$request->password])) {
            return response(['message' => 'Invalid credentials']);
        }
        else {
            $user = Auth::user();
            $api_token = $user->createToken('login_token')->plainTextToken;
            return response(['user' => auth()->user(), 'token' => $api_token]);}
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'User Successfully Logged Out'
        ],200);
    }
}
