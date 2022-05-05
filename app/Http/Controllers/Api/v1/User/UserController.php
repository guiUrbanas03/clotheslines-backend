<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return $this->userService->getAllUsers();
    }

    public function find(Request $request)
    {
        $userId = $request->user_id;

        return $this->userService->getUser($userId);
    }

    public function update(Request $request)
    {
        $userId = $request->user_id;
        $userDTO = $request->user;
        $profileDTO = $request->profile;

        $user = User::find($userId);

        $validator = Validator::make($request->only('user', 'profile'), [
            'user.email' => ['required', Rule::unique('users', 'email')->ignore($userId), 'email', 'max:320'],
            'profile.nickname' => ['required', Rule::unique('profiles', 'nickname')->ignore($user->profile->id), 'string', 'max:20'],
            'profile.first_name' => ['required', 'string', 'max:100'],
            'profile.last_name' => ['required', 'string', 'max: 100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'error while updating user',
                'errors' => $validator->getMessageBag()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->userService->updateUser($userId, $userDTO, $profileDTO);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user_id;

        return $this->userService->deleteUser($userId);
    }

    public function restore(Request $request)
    {
        $userId = $request->user_id;

        return $this->userService->restoreUser($userId);
    }
}
