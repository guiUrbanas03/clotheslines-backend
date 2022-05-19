<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterUserRequest $request)
    {
        $userDTO = $request->get('user');
        $profileDTO = $request->get('profile');

        $registeredUser = $this->authService->registerUser($userDTO, $profileDTO);

        return $this->sendAuthenticatedUserResponse(
            $registeredUser,
            'User registered successfully',
            'Failed to register user',
        );
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $loggedUser = $this->authService->loginWithEmailAndPassword($credentials);

        if (!$loggedUser) {
            return false;
        }

        $request->session()->regenerate();

        return $this->sendAuthenticatedUserResponse(
            $loggedUser,
            'User authenticated successfully',
            'Invalid credentials'
        );
    }

    public function logout()
    {
        $this->authService->logout();

        return $this->jsonResponse([
            'message' => 'User logged out successfully',
        ]);
    }

    public function me()
    {
        $authenticatedUser = $this->authService->me()->resource;

        return $this->jsonResponse([
            'message' => 'Authenticated user found succesfully',
            'user' => $authenticatedUser
        ]);
    }

    private function sendAuthenticatedUserResponse(User $user, $successResponseMessage = '', $failResponseMessage = '')
    {
        if (!$user) {
            return $this->jsonResponse([
                'message' => $failResponseMessage
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->jsonResponse([
            'message' => $successResponseMessage,
            'user' => $user->resource,
        ], Response::HTTP_OK);
    }
}
