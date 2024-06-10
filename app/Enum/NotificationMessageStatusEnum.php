<?php

declare(strict_types=1);

namespace App\Enum;

class NotificationMessageStatusEnum
{
    const NOT_SENT = 0;
    const SENT = 1;

    public static function statuses(): array
    {
        return [
            self::NOT_SENT => trans('messages.not_sent'),
            self::SENT => trans('messages.sent'),
        ];
    }

    public static function getStatusKeysString(): string
    {
        return implode(',', array_keys(self::statuses()));
    }
}
