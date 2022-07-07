<?php

namespace App\Services\Auth;

use App\Services\User\UserService;
use Illuminate\Support\Facades\Auth;

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

    public function authenticateUser($credentials)
    {
        $areCredentialsCorrect = Auth::attempt($credentials);

        if (!$areCredentialsCorrect) {
            return false;
        }

        $authenticatedUser = Auth::user();

        return $authenticatedUser;
    }

    public function me()
    {
        return Auth::user();
    }
}
