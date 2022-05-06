<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\Auth\LoginRequest;
use App\Http\Requests\Api\v1\Auth\RegisterUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        return $this->sendAuthenticatedUserResponse($registeredUser);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        $userCredentials = $this->authService->loginWithEmailAndPassword($credentials);

        return $this->sendAuthenticatedUserResponse($userCredentials);
    }

    public function logout()
    {
        $cookie = $this->authService->logout();

        return response([
            'message' => 'User logged out',
        ])->withCookie($cookie);
    }

    public function me()
    {
        return new UserResource($this->authService->me());
    }

    private function sendAuthenticatedUserResponse($userCredentials)
    {
        if (!$userCredentials) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            'message' => 'User authenticated',
            'user' => $userCredentials['user']
        ], Response::HTTP_OK)->withCookie($userCredentials['cookie']);
    }
}
