<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;

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
            'token' => $token ,
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
            return response([
                'message' => 'You successfully Logged In.',
                'user' => auth()->user() ,
                'token' => $api_token
            ]);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'User Successfully Logged Out.'
        ],200);
    }
    public function forget(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset password link sent to your email'], 200)
            : response()->json(['message' => 'Unable to send reset password link'], 400);
    }
    public function reset(ResetPasswordRequest $request)
    {
        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
        });

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully'], 200)
            : response()->json(['message' => 'Unable to reset password'], 400);
    }
}
