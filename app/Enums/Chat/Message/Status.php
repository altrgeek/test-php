<?php

namespace App\Enums\Chat\Message;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Status: string
{
    use Values, InvokableCases;

    case SENT = "sent"; // Sent in chat room
    case DELIVERED = "delivered"; // Delivered to all participants
    case SEEN = "seen"; // Seen by all participants
}
