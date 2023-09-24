<?php

namespace App\Http\Controllers\User;

use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DepositRequest;
use App\Service\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
    }

    public function deposit(DepositRequest $request)
    {
        try {
            $this->userService->deposit($request->validated());

        } catch(CustomException $e) {

        }
    }
}
