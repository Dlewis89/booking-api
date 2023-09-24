<?php

namespace App\Service\Auth;

use App\Exceptions\CustomException;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function __construct(private User $userModel)
    {
    }

    public function register(array $data)
    {
        $user = $this->userModel->create($data);

        return $this->append_token_to_user($user);
    }

    public function respondWithToken($user = null)
    {
        $token = JWTAuth::fromUser($user ?? auth()->user());

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }

    public function authenticate(array $request)
    {
        if (! auth()->attempt($request)) {
            throw new CustomException('Invalid Credentials', Response::HTTP_UNAUTHORIZED);
        }

        return $this->append_token_to_user(auth()->user());
    }

    public function append_token_to_user(User|Authenticatable $user)
    {
        return array_merge((new UserResource($user))->toArray(request()), $this->respondWithToken($user));
    }
}
