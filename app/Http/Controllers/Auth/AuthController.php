<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Service\User\UserService;
use Exception;

class AuthController extends Controller
{
    public function __construct(private UserService $userService )
    {
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userService->register($request->validated());
            return response()->success('user created', $user, 201);
        } catch(Exception $e) {
            report($e);
            return response()->errorResponse('something went wrong', $e);
        }
    }
}
