<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request) : JsonResponse
    {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make( $request->all(), User::$registerRules);
        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['message' => $messages], 422);
        }

        $validated = $validator->validated();
        $user = new User();
        $user->email = $validated['email'];
        $user->name = $validated['name'];
        $user->login = $validated['login'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => new UserResource($user),
        ];

        return response()->json($response, 201);
    }

    public function login(Request $request) : JsonResponse
    {
        $request['login'] = strtolower($request['login']);
        $validator = Validator::make($request->all(), User::$loginRules);

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return response()->json(['message' => $messages], 422);
        }

        $validated = $validator->validated();

        if (!Auth::attempt(['login' => $validated['login'], 'password' => $validated['password']])) {
            return response()->json(['message' => 'Wrong login or password'], 422);
        }

        $user = User::query()->where('login', $validated['login'])->first();
        $token = $user->createToken('token')->plainTextToken;

        $response = [
            'token' => $token,
            'user' => new UserResource($user)
        ];

        return response()->json($response);
    }

    public function logout() : JsonResponse
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Logged out']);
    }

    public function profile() : JsonResponse
    {
        $user = Auth::user();
        return response()->json([new UserResource($user)]);
    }
}
