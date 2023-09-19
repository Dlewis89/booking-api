<?php

namespace App\Service\User;

use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function __construct(private User $userModel)
    {
    }

    public function register(array $data)
    {
        $user = $this->userModel->create($data);

        return array_merge($user->toArray(), $this->respondWithToken($user));
    }

    public function respondWithToken($user = null)
    {
        $token = JWTAuth::fromUser($user ?? auth()->user());

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }
}
