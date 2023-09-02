<?php

namespace App\Enums\Chat;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Visibility: string
{
    use Values, InvokableCases;

    case MUTED = "muted";
    case ARCHIVED = "archived";
    case BLOCKED = "blocked";
    case REMOVED = "removed";
}
