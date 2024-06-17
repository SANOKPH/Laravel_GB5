<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserLoginRequest;
use App\Http\Requests\User\UserRegisterRequest;
use App\Http\Resources\User\ProfileResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $user = User::createOrUpdate($request);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data'          => $user,
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    // user login
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'User not found'
            ], 401);
        }

        $user   = User::where('email', $request->email)->firstOrFail();
        $token  = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message'       => 'Login success',
            'access_token'  => $token,
            'token_type'    => 'Bearer'
        ]);
    }

    // user logout
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout successfull'
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $permissions = $user->getAllPermissions();
        $roles = $user->getRoleNames();
        return response()->json([
            'message' => 'Welcome to your profile',
            'data' => new ProfileResource($user),
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        dd($request);
    }
}
