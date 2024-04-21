<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect()
    {
        // Redirect to Google's OAuth 2.0 server
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            // Attempt to retrieve the user from Google's OAuth server
            $google_user = Socialite::driver('google')->user();
            $user = User::where('Google_Id', $google_user->getId())->first();

            if (!$user) {
                // Create a new user if it does not exist
                $newUser = User::create([
                    'username' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'Google_Id' => $google_user->getId(),
                    'avatar' => $google_user->getAvatar(),
                ]);

                Auth::login($newUser); // Log in the new user
                return redirect()->route('SelectPosition'); // Redirect to a specific route
            } else {
                Auth::login($user); // Log in the existing user
                return redirect()->intended('/'); // Redirect to the intended URL or home if not set
            }
        } catch (\Exception $e) {
            // Handle exceptions and display an error message
            \Log::error('Google OAuth error: ' . $e->getMessage());
            return redirect('login')->with('error', 'Failed to authenticate with Google.');
        }
    }

    public function logout()
    {
        Auth::logout(); // Log out the user
        return redirect()->route('login')->with('success', 'Successfully logged out.');
    }
}
