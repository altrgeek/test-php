<?php

namespace App\Traits;

use App\Traits\Roles\HasRelations;
use App\Traits\Roles\HasValidators;
use Spatie\Permission\Traits\HasRoles as HasSpatieRoles;

trait HasRoles
{
    use HasRelations, HasValidators, HasSpatieRoles;
}
