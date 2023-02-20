<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationsType extends Enum
{
    const MATCH = 1;
    const LIKE = 2;
    const ALBUM_VIEWING_REQUEST = 3;
}
