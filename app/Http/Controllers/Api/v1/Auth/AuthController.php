<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $loggedUser = $this->authService->authenticateUser($credentials);

        if ($loggedUser) {
            $request->session()->regenerate();
        }

        return $this->sendAuthenticatedUserResponse(
            $loggedUser,
            'User authenticated successfully',
            'Invalid credentials'
        );
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        $request->session()->flush();

        $request->session()->regenerateToken();

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

    private function sendAuthenticatedUserResponse($user, $successResponseMessage = '', $failResponseMessage = '')
    {
        if (!$user || $user == null) {
            return $this->jsonResponse([
                'message' => $failResponseMessage,
                'errors' => [
                    'auth' => $failResponseMessage,
                ]

            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->jsonResponse([
            'message' => $successResponseMessage,
            'user' => $user->resource,
        ], Response::HTTP_OK);
    }
}
