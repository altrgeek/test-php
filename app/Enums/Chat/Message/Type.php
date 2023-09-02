<?php

namespace App\Enums\Chat\Message;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Values;

enum Type: string
{
    use Values, InvokableCases;

    case TEXT = "text";
    case IMAGE = "image";
    case AUDIO = "audio";
    case VIDEO = "video";
    case VOICE = "voice";
    case DOCUMENT = "document";
    case EVENT = "event";
}
