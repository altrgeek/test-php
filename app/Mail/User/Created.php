<?php

namespace App\Mail\User;

use Exception;
use App\Models\User;
use Illuminate\Mail\Mailable;
use InvalidArgumentException;
use Illuminate\Queue\SerializesModels;

class Created extends Mailable
{
    use SerializesModels;

    /**
     * User who created new user's record
     *
     * @var \App\Models\User
     */
    public $creator;

    /**
     * The user being created
     *
     * @var \App\Models\User
     */
    public $created;

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
        User $creator,
        User $created,
        string $password,
        string $role,
        string $segment = null
    ) {
        $this->creator = $creator;
        $this->created = $created;
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
            ->subject('New account registered!')
            ->markdown('emails.user.created');
    }
}
