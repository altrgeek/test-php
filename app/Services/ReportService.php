<?php

namespace App\Services;

use App\Contracts\ReportService as ReportServiceContract;
use App\Models\User;
use Illuminate\Support\Collection;

abstract class ReportService implements ReportServiceContract
{
    protected User $user;

    /**
     * {@inheritdoc}
     */
    public function user(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function forUser(User $user): static
    {
        return (new static)->user($user);
    }

    /**
     * Process the stats and generate report.
     *
     * @param  mixed  $options
     * @return self
     */
    abstract public function generate(mixed $options = null): self;

    /**
     * Export the generated report in array format.
     *
     * @param  mixed  $options
     * @return \Illuminate\Support\Collection
     */
    abstract public function export(mixed $options = null): Collection;
}
