<?php

namespace App\Service\User;

use App\Models\Wallet;

class UserService
{

    public function __construct(private Wallet $walletService)
    {
    }

    public function deposit($request)
    {
        $this->walletService->credit($request->amount);
    }
}
