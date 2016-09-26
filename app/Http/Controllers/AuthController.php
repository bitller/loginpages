<?php

namespace App\Http\Controllers;

use Socialite;
use App\User;
use App\Role;
use Auth;
use App\Http\Controllers\BaseController;

/**
 * Handle user authentication with google, facebook or github.
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class AuthController extends BaseController {

    /**
     * Redirect to github provider.
     */
    public function redirectToGithubProvider() {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Handle github provder callback.
     */
    public function handleGithubProviderCallback() {
        $this->user = Socialite::driver('github')->user();
        return $this->loginOrRegisterUser('github');
    }

    /**
     * Redirect to google provider.
     */
    public function redirectToGoogleProvider() {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle google provider callback.
     */
    public function handleGoogleProviderCallback() {
        $this->user = Socialite::driver('google')->user();
        return $this->loginOrRegisterUser('google');
    }

    /**
     * Redirect to facebook provider.
     */
    public function redirectToFacebookProvider() {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Handle facebook provider callback.
     */
    public function handleFacebookProviderCallback() {
        $this->user = Socialite::driver('facebook')->user();
        return $this->loginOrRegisterUser('facebook');
    }

    /**
     * Log user out.
     */
    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    /**
     * Register or login userr with given provder.
     *
     * @param string $provider Accepted providers: facebook, google and github.
     */
    protected function loginOrRegisterUser($provider) {

        // Check if a user exists with given email
        $user = User::where('email', $this->user->getEmail())->first();

        // If user does not exists, register
        if (!$user) {
            $user = $this->registerUser($provider);
            // First user will be admin, all othrs will be normal
            if (User::count() < 2) {
                $admin = Role::where('name', 'admin')->first();
                $user->attachRole($admin);
            } else {
                $normalUser = Role::where('name', 'user')->first();
                $user->attachRole($normalUser);
            }
        }

        // If we arrive here an user with given email already exists. Now check if is registered with given provider
        if (!User::where('email', $this->user->getEmail())->where($provider . '_id', $this->user->getId())->count()) {

            // If arrive here user exists in database but wrong choosed the wrong provider. Display a message to inform about that
            $providerFormatted = 'Google';
            if ($user->facebook_id) {
                $providerFormatted = 'Facebook';
            }
            if ($user->github_id) {
                $providerFormatted = 'Github';
            }
            return response()->json([
                'wrong_provider' => 'You need to connect with ' . $providerFormatted . ' in order to access your account.',
            ], 422);
        }

        // Make sure the account is enabled
        if ($user->disabled) {
            return response()->json([
                'account_disabled' => 'This account is disabled.'
            ]);
        }

        $this->loginUser($user);
        return redirect('/');
    }

    /**
     * Just register a new user.
     */
    protected function registerUser($provider) {
        return User::create([
            $provider . '_id' => $this->user->getId(),
            'name' => $this->user->getName(),
            'email' => $this->user->getEmail()
        ]);
    }

    /**
     * Log in user.
     */
    protected function loginUser($user) {
        Auth::login($user);
    }
}
