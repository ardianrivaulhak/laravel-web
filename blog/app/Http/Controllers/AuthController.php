<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            # code...
            return response()->json([$validator->errors()->toJson()], 401);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' => 'User Successfully Created',
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|string|email',
                'password' => 'required|string|min:6',
            ]
        );

        if ($validator->fails()) {
            # code...
            return response()->json([$validator->errors()->toJson()], 401);
        }

        if (!$token = auth()->attempt($validator->validate())) {
            # code...
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        return $this->createNewToken($token);
    }

    public function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }

    public function index()
    {
        $model = User::all();
        return response()->json([
            'status' => 'success',
            'model' => $model,
        ]);
    }
}
