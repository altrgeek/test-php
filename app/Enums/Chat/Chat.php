<?php

namespace App\Enums\Chat;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Chat: string
{
    use Values, InvokableCases;

    case INDIVIDUAL = "individual";
    case GROUP = "group";
}
