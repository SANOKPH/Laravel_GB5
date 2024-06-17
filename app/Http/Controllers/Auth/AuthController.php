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

/**
 * @OA\Post(
    * path="/api/register",
    * summary="Register a new user",
    * @OA\Parameter(
        * name="first_name",
        * in="query",
        * description="User’s first_name",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="last_name",
        * in="query",
        * description="User’s last_name",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="email",
        * in="query",
        * description="User’s email",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="password",
        * in="query",
        * description="User’s password",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="phone",
        * in="query",
        * description="User’s phone",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="image",
        * in="query",
        * description="User’s image",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * 
    * @OA\Response(response="201", description="User registered successfully"),
    * @OA\Response(response="422", description="Validation errors")
 * )
 */
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

/**
 * @OA\Post(
    * path="/api/login",
    * summary="login to your account",
    * @OA\Parameter(
        * name="email",
        * in="query",
        * description="User’s email",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="password",
        * in="query",
        * description="User’s password",
        * @OA\Schema(type="password")
    * ),
    * @OA\Response(response="201", description="User login successfully"),
    * @OA\Response(response="422", description="Validation errors")
 * )
 */
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

    
/**
 * @OA\Post(
    * path="/api/logout",
    * summary="logout from your account",
    * @OA\Parameter(
        * name="email",
        * in="query",
        * description="User’s email",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Parameter(
        * name="password",
        * in="query",
        * description="User’s password",
        * required=true,
        * @OA\Schema(type="string")
    * ),
    * @OA\Response(response="201", description="User login successfully"),
    * @OA\Response(response="422", description="Validation errors")
 * )
 */
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
