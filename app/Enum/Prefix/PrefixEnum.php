<?php

namespace App\Enum\Prefix;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum PrefixEnum: string
{
    use InvokableCases, Values, Names;

    case WALLET_TXN = 'W_TXN_';
}
