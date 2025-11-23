<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect to OAuth provider
     */
    public function redirect(string $provider)
    {
        $this->validateProvider($provider);

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle OAuth callback
     */
    public function callback(string $provider)
    {
        $this->validateProvider($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'SSO authentication failed. Please try again.');
        }

        // Find or create user
        $user = $this->findOrCreateUser($socialUser, $provider);

        // Login user
        Auth::login($user, true);

        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }

    /**
     * Find existing user or create new one from SSO data
     */
    protected function findOrCreateUser($socialUser, string $provider): User
    {
        // Check if user exists with this SSO provider ID
        $user = User::where('sso_provider', $provider)
            ->where('sso_id', $socialUser->getId())
            ->first();

        if ($user) {
            // Update SSO data
            $user->update([
                'sso_data' => [
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'avatar' => $socialUser->getAvatar(),
                ],
                'last_sso_sync' => now(),
            ]);

            return $user;
        }

        // Check if user exists with matching email (password-based account)
        $user = User::where('email', $socialUser->getEmail())->first();

        if ($user) {
            // Link existing account to SSO
            $user->update([
                'sso_provider' => $provider,
                'sso_id' => $socialUser->getId(),
                'sso_data' => [
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'avatar' => $socialUser->getAvatar(),
                ],
                'last_sso_sync' => now(),
            ]);

            return $user;
        }

        // Create new user from SSO
        // Note: For multi-tenant apps, you'll need to determine tenant assignment
        // This could be based on email domain, invite codes, etc.
        return User::create([
            'name' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'password' => null, // SSO-only users don't need passwords
            'sso_provider' => $provider,
            'sso_id' => $socialUser->getId(),
            'sso_data' => [
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'avatar' => $socialUser->getAvatar(),
            ],
            'last_sso_sync' => now(),
            'email_verified_at' => now(), // Trust SSO provider verification
        ]);
    }

    /**
     * Validate that provider is supported
     */
    protected function validateProvider(string $provider): void
    {
        if (!in_array($provider, ['microsoft', 'google'])) {
            abort(404);
        }
    }
}
