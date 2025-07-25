<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function register (Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);
        
        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    public function login (Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            return response()->json([
                'response_code' => 401,
                'message' => 'User with email provided does not exist.'
            ]);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'response_code' => 200,
            'status'        => 'success',
            'message'       => 'Login successful',
            'user_info'     => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
            ],
            'token'       => $token,
            'token_type'  => 'Bearer',
        ]);
    }

    public function logout (Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are now logged out',
        ];
    }
}
