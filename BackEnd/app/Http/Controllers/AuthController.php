<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'user_name' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'age' => 'required|numeric',
            'gender' => 'required|string',
            ]);
            
                $user = User::create([
                    'user_name' => $validatedData['user_name'],
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'age' => $validatedData['age'],
                    'gender' => $validatedData['gender']
                ]);
            
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json([
                        'access_token' => $token,
                            'token_type' => 'Bearer',
            ]);
    }
    public function login(Request $request) {
        if (!Auth::attempt($request->only('user_name', 'password'))) {
        return response()->json([
        'message' => 'Invalid login details'
                ], 401);
            }
        
        $user = User::where('user_name', $request['user_name'])->firstOrFail();
        
        $token = $user->createToken('auth_token')->plainTextToken;
            
        return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
        ]);
    }

    public function logout() {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }

    public function getAccount(Request $request) {
        return $request->user();
    }
}