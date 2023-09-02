<?php

namespace App\Mail\User;

use App\Models\User;
use Illuminate\Mail\Mailable;
use InvalidArgumentException;
use Illuminate\Queue\SerializesModels;

class Updated extends Mailable
{
    use SerializesModels;

    /**
     * User who is updated the user's record
     *
     * @var \App\Models\User
     */
    public $updating;

    /**
     * The user being updated
     *
     * @var \App\Models\User
     */
    public $updated;

    /**
     * The original password of the user
     *
     * @var string
     */
    public $password;

    /**
     * The role of the created account
     *
     * @var string
     */
    public $role;

    /**
     * The segment of admin (if provided)
     *
     * @var ?string
     */
    public $segment = null;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        User $updating,
        User $updated,
        string $password,
        string $role,
        string $segment = null
    ) {
        $this->updating = $updating;
        $this->updated = $updated;
        $this->password = $password;
        $this->role = $role;
        $this->segment = $segment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Account updated!')
            ->markdown('emails.user.updated');
    }
}
