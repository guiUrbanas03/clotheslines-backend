<?php

namespace App\Services\Auth;

use App\Enums\ApiAuth;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Laravel\Sanctum\NewAccessToken;

class AuthService
{
    protected $userService;
    private $authTokenName = ApiAuth::API_AUTH_TOKEN_NAME;
    private $authCookieName = ApiAuth::API_AUTH_COOKIE_NAME;
    private $authCookieExpirationTime = 60 * 24;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registerUser($userData, $profileData)
    {
        $user = $this->userService->createUser($userData, $profileData);

        if (!$user) return false;

        $tokenCookie = $this->createTokenAndCookie($user);

        return [
            'user' => $user,
            'cookie' => $tokenCookie['cookie']
        ];
    }

    public function loginWithEmailAndPassword($credentials)
    {
        $areCredentialsCorrect = Auth::attempt($credentials);

        if (!$areCredentialsCorrect) return false;

        $authenticatedUser = Auth::user();

        $tokenCookie = $this->createTokenAndCookie($authenticatedUser);

        return [
            'user' => $authenticatedUser,
            'cookie' => $tokenCookie['cookie']
        ];
    }

    public function logout()
    {
        $cookie = Cookie::forget($this->authCookieName);

        return $cookie;
    }

    public function me()
    {
        return Auth::user();
    }

    private function createAuthUserToken(User $user)
    {
        $token = $user->createToken($this->authTokenName);

        return $token;
    }

    private function createCookieWithAuthUserToken(NewAccessToken $token)
    {
        $cookie = cookie($this->authCookieName, $token->plainTextToken, $this->authCookieExpirationTime);

        return $cookie;
    }

    private function createTokenAndCookie(User $user)
    {
        $token = $this->createAuthUserToken($user);
        $cookie = $this->createCookieWithAuthUserToken($token);

        return [
            'token' => $token,
            'cookie' => $cookie
        ];
    }
}
