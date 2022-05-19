<?php

namespace App\Services\Auth;

use App\Enums\ApiAuth;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registerUser($userData, $profileData)
    {
        $user = $this->userService->createUser($userData, $profileData);

        if (!$user) return false;

        return $user;
    }

    public function loginWithEmailAndPassword($credentials)
    {
        $areCredentialsCorrect = Auth::attempt($credentials);

        if (!$areCredentialsCorrect) {
            return false;
        }

        $authenticatedUser = Auth::user();

        return $authenticatedUser;
    }

    public function logout()
    {
        Auth::logout();
    }

    public function me()
    {
        return Auth::user();
    }
}
