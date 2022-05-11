<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\v1\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\Request;
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
        $users = UserResource::collection($this->userService->getAllUsers());

        return $this->jsonResponse([
            'message' => 'Users found successfully',
            'users' => $users
        ], Response::HTTP_OK);
    }

    public function find(Request $request)
    {
        $userId = $request->user_id;

        return $this->jsonResponse([
            'message' => 'User found successfully',
            'user' => $this->userService->getUser($userId)->resource
        ]);
    }

    public function update(UpdateUserRequest $request)
    {
        $userId = $request->user_id;
        $userDTO = $request->user;
        $profileDTO = $request->profile;

        $updatedUser = $this->userService->updateUser($userId, $userDTO, $profileDTO);

        return $this->jsonResponse([
            'message' => 'User updated successfully',
            'user' => $updatedUser->resource
        ]);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user_id;

        $deletedUser = $this->userService->deleteUser($userId);

        return $this->jsonResponse([
            'message' => 'User deleted successfully',
            'user' => $deletedUser->resource
        ]);
    }

    public function restore(Request $request)
    {
        $userId = $request->user_id;

        $restoredUser =  $this->userService->restoreUser($userId);

        return $this->jsonResponse([
            'message' => 'User restored successfully',
            'user' => $restoredUser->resource
        ]);
    }
}
