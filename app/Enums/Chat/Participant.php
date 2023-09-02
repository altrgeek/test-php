<?php

namespace App\Enums\Chat;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Participant: string
{
    use Values, InvokableCases;

    case MEMBER = "member";
    case ADMIN = "admin";
    case OWNER = "owner";
}
