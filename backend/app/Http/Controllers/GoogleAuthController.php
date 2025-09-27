<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class GoogleAuthController extends Controller
{
    //

    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback(Request $request)
    {
        try {
            // Get the user information from Google
            $user = Socialite::driver('google')->stateless()->user();
        } catch (Throwable $e) {
            return redirect("http://localhost:5173/login")->with('error', 'Google authentication failed.');
        }

        // Check if the user already exists in the database
        $existingUser = User::where('email', $user->email)->first();

        if ($existingUser) {
            // Create Sanctum token
            $token = $existingUser->createToken('auth_token')->plainTextToken;
        } else {
            // Otherwise, create a new user and log them in
            $newUser = User::updateOrCreate([
                'email' => $user->email
            ], [
                'name' => $user->name,
                'password' => bcrypt(Str::random(16)), // Set a random password
                'email_verified_at' => now()
            ]);

            $token = $newUser->createToken('auth_token')->plainTextToken;
        }

        // Redirect back to Vue with token
        return redirect("http://localhost:5173/auth/callback?token=" . urlencode($token));
    }
}
