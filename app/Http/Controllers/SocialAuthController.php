<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    /**
     * Redirect to the OAuth provider
     */
    public function redirect($provider)
    {
        // For Facebook, we need to specify fields explicitly
        if ($provider === 'facebook') {
            return Socialite::driver($provider)
                ->fields(['name', 'email'])
                ->scopes(['public_profile'])
                ->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle the OAuth provider callback
     */
    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();

            // Find or create user
            $user = User::where('email', $socialUser->getEmail())->first();

            if ($user) {
                // Update existing user with provider info
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // Create new user
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(24)),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'provider_token' => $socialUser->token,
                    'avatar' => $socialUser->getAvatar(),
                    'role' => 'free_member',
                    'subscription_tier' => 'free',
                    'is_active' => true,
                ]);
            }

            Auth::login($user, true);

            return redirect()->intended('dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Failed to authenticate with ' . ucfirst($provider));
        }
    }
}
