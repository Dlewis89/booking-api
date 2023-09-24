<?php

namespace App\Service\Wallet;
use App\Enum\Prefix\PrefixEnum;
use App\Enum\User\ReasonEnum;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Auth\Authenticatable;

class WalletService
{

    public function __construct(private Wallet $walletModel)
    {
    }

    protected function getOldBalance(User|Authenticatable $user)
    {
        return $this->walletModel->where('user_id', $user->id)->latest()->first()?->balance_after_transaction ?? 0;
    }

    public function credit($amount)
    {
        $this->walletModel->create([
            'ref' => generate_ref(PrefixEnum::WALLET_TXN()),
            'is_credit' => true,
            'amount' => $amount,
            'old_balance'=> $this->getOldBalance(auth()->user()),
            'balance_after_transaction'=> $amount + $this->getOldBalance(auth()->user()),
            'reason' => ReasonEnum::WALLET_DEPOSIT()
        ]);
    }

    public function debit($amount)
    {
        $this->walletModel->create([
            'ref' => generate_ref(PrefixEnum::WALLET_TXN()),
            'is_credit' => false,
            'amount' => $amount,
            'old_balance'=> $this->getOldBalance(auth()->user()),
            'balance_after_transaction'=> $this->getOldBalance(auth()->user()) - $amount,
            'reason' => ReasonEnum::WALLET_WITHDRAW()
        ]);
    }
}
