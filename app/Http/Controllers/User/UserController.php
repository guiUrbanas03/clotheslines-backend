<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        return $this->userService->getAllUsers();
    }

    public function find(Request $request)
    {
        $userId = $request->user_id;

        return $this->userService->getUser($userId);
    }

    public function store(Request $request)
    {
        $userDTO = $request->user;
        $profileDTO = $request->profile;

        return $this->userService->createUser($userDTO, $profileDTO);
    }

    public function update(Request $request)
    {
        $userId = $request->user_id;
        $userDTO = $request->user;
        $profileDTO = $request->profile;

        return $this->userService->updateUser($userId, $userDTO, $profileDTO);
    }

    public function destroy(Request $request)
    {
        $userId = $request->user_id;

        return $this->userService->deleteUser($userId);
    }
}