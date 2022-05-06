<?php

namespace App\Http\Controllers\Api\v1\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return UserResource::collection($this->userService->getAllUsers());
    }

    public function find(Request $request)
    {
        $userId = $request->user_id;

        return new UserResource($this->userService->getUser($userId));
    }

    public function update(Request $request)
    {
        $userId = $request->user_id;
        $userDTO = $request->user;
        $profileDTO = $request->profile;

        $updatedUser = $this->userService->updateUser($userId, $userDTO, $profileDTO);

        return new UserResource($updatedUser);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user_id;

        $deletedUser = $this->userService->deleteUser($userId);

        return new UserResource($deletedUser);
    }

    public function restore(Request $request)
    {
        $userId = $request->user_id;

        $restoredUser =  $this->userService->restoreUser($userId);

        return new UserResource($restoredUser);
    }
}
