<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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

        $validator = Validator::make($request->only('user', 'profile'), [
            'user.email' => ['required', Rule::unique('users', 'email'), 'email', 'max:320'],
            'user.password' => ['required', 'string', 'max:999', 'min:8', 'confirmed'],
            'user.password_confirmation' => ['required', 'string', 'max:999', 'min:8'],
            'profile.nickname' => ['required', Rule::unique('profiles', 'nickname'), 'string', 'max:20'],
            'profile.first_name' => ['required', 'string', 'max:100'],
            'profile.last_name' => ['required', 'string', 'max: 100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error while registering user',
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $registeredUser = $this->authService->registerUser($userDTO, $profileDTO);

        return $this->sendAuthUserResponse($registeredUser);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => ['required', 'email', 'max:320'],
            'password' => ['required', 'string', 'max:999', 'min:8']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error while logging user',
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
