<?php

namespace App\Enum\User;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum ReasonEnum: string
{
    use InvokableCases, Values, Names;

    case WALLET_DEPOSIT = 'Wallet deposit';
    case WALLET_WITHDRAW = 'Wallet balance withdrawal';
}
