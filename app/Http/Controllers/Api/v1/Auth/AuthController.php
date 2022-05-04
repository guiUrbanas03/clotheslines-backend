<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(Request $request)
    {
        $userDTO = $request->get('user');
        $profileDTO = $request->get('profile');

        $registeredUser = $this->authService->registerUser($userDTO, $profileDTO);

        return $this->sendAuthUserResponse($registeredUser);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $userCredentials = $this->authService->loginWithEmailAndPassword($credentials);

        return $this->sendAuthUserResponse($userCredentials);
    }

    public function logout()
    {
        $cookie = $this->authService->logout();

        return response([
            'message' => 'Success',
        ])->withCookie($cookie);
    }

    public function me()
    {
        return $this->authService->me();
    }

    private function sendAuthUserResponse($userCredentials)
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
