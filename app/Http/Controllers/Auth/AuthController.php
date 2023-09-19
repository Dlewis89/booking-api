<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Requests\Auth\LoginUserRequest;
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
            return response()->errorResponse('something went wrong');
        }
    }

    public function login(LoginUserRequest $request)
    {
        try{
            $user = $this->userService->authenticate($request->only(['email', 'password']));
            return response()->success('login successful', $user);
        }catch (CustomException $e) {
            report($e);
            return response()->errorResponse($e->getMessage(), [], $e->getCode());
        } catch(Exception $e) {
            report($e);
            return response()->errorResponse($e->getMessage(), [], 500);
        }
    }
}
