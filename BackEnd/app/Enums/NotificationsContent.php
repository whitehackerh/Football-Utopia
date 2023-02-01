<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationsContent extends Enum
{
    const MATCH = 'Matched with ';
    const LIKE = ' has liked you.';
    const ALBUM_VIEWING_REQUEST_FIRST = 'You have received a request from ';
    const ALBUM_VIEWING_REQUEST_LATTER = ' to see your album.';
}
