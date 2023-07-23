<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackGoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('googleID', $google_user->getId())->first();

            // if (explode("@", $google_user->email)[1] !== 'widyatama.ac.id') {
            //     return redirect()->to('login')->with('failed', 'Barudak Widit Hungkul Cuyy, Pake Email Widit Geura');
            // }

            if (!$user) {
                $newUser = User::create([
                    // 'fullname' => explode("/", $google_user->getName())[2],
                    // 'npm' => explode("/", $google_user->getName())[1],
                    'name' => $google_user->getName(),
                    'email' => $google_user->getEmail(),
                    'googleID' => $google_user->getId(),
                    'avatar' => $google_user->getAvatar(),
                ]);

                Auth::login($newUser);

                return redirect()->route('SelectUnit');
            } else {
                
                Auth::login($user);
                
                if (!empty($user->BisnisUnitID)) {
                    
                    return redirect()->intended('/');
                }
                return redirect()->route('SelectUnit');
            }
        } catch (\Throwable $th) {
            dd('Error ' . $th);
        }
    }
}