<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Mail\ResetPasswordSuccessfully;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['message' => 'Invalid credentials']);
        } else {
            $user = Auth::user();
            $api_token = $user->createToken('login_token')->plainTextToken;
//            Mail::to($request->email)->send(new  LoginUserSuccessfully());
            return response([
                'message' => 'ورود موفق - خوش آمدید',
                'user' => auth()->user(),
                'token' => $api_token
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'خروج موفق'
        ], 200);
    }

    public function forget(ForgotPasswordRequest $request)
    {
        $response = Password::sendResetLink($request->only('email'));
        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'لینک بازیابی رمزعبور به ایمیل شما ارسال شد'], 200)
            : response()->json(['message' => 'مشکلی در ارسال لینک پیش آمده'], 400);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password),
                'remember_token' => Str::random(60),
            ])->save();
        });
        if ($response == Password::PASSWORD_RESET) {
            $user = User::where('email', $request->email)->first();
            Mail::to($user->email)->send(new ResetPasswordSuccessfully());
            return response()->json(['message' => 'رمزعبود با موفقیت بروزرسانی شد'], 200);
        } else {
            return response()->json(['message' => 'بازنشانی رمزعبور ممکن نیست'], 400);
        }
    }

    public function verifyToken(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->token);
        if ($token) {
            return response()->json(User::find($token->tokenable_id));
        } else {
            return response()->json(['message' => "Unauthenticated."
            ],401);
        }
    }
}
