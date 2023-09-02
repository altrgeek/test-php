<?php

namespace App\Contracts;

use App\Models\User;

interface ReportService
{
    /**
     * Set the user for which the report is to be generated.
     *
     * @param  \App\Models\User  $user
     * @return self
     */
    public function user(User $user): self;

    /**
     * Creates a new report instances and sets the user for which the report is
     * to be generated.
     *
     * @param  \App\Models\User  $user
     * @return static
     */
    public static function forUser(User $user): static;
}
