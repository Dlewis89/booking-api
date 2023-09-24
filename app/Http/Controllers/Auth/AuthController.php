<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Service\Auth\AuthService;
use Exception;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(private AuthService $userService)
    {
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            $user = $this->userService->register($request->validated());

            return response()->success('user created', $user, Response::HTTP_CREATED);
        } catch (Exception $e) {
            report($e);

            return response()->errorResponse('something went wrong');
        }
    }

    public function login(LoginUserRequest $request)
    {
        try {
            $user = $this->userService->authenticate($request->only(['email', 'password']));

            return response()->success('login successful', $user);
        } catch (CustomException $e) {
            report($e);

            return response()->errorResponse($e->getMessage(), [], $e->getCode());
        } catch (Exception $e) {
            report($e);

            return response()->errorResponse($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
