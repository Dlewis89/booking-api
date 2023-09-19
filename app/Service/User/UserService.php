<?php

namespace App\Service\User;

use App\Exceptions\CustomException;
use App\Http\Resources\User\UserResource;
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

        return array_merge($user->toArray(), $this->respondWithToken($user)->toArray());
    }

    public function respondWithToken($user = null)
    {
        $token = JWTAuth::fromUser($user ?? auth()->user());

        return (object) [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ];
    }

    public function authenticate(array $request)
    {
        $email = $request['email'];
        $user = $this->userModel->firstWhere('email', $email);

        if (!$user) {
            throw new CustomException('Invalid Credentials', 401);
        }

        if (!auth('web')->attempt(['email' => $email, 'password' => $request['password']])){
            throw new CustomException('Invalid Credentials', 401);
        }

        $token = $this->respondWithToken($user);

        return $this->append_token_to_user($token, $user);
    }

    public function append_token_to_user($token, User $user)
    {
        if(!is_object($token) || !property_exists($token, 'access_token')) {
            throw new CustomException('Invalid data', 400);
        }
        return array_merge((new UserResource($user))->toArray(request()), ['token' => $token]);
    }
}
