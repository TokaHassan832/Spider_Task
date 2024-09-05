<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegisterRequest $request): UserResource
    {

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->hasFile('image')) {
            $user->image = $request->file('image')->store('avatars', 'public');
            $user->save();
        }

        return new UserResource($user);
    }
    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('userToken')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => new UserResource($user)
            ], 200);
        }

        return response()->json(['error' => 'Invalid credentials'], 401);
    }

}
