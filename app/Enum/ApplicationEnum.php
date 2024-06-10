<?php

declare(strict_types=1);

namespace App\Enum;

class ApplicationEnum
{
    const NEW = 0;
    const VIEWED = 1;

    public static function statuses(): array
    {
        return [
            self::NEW => 'Новый',
            self::VIEWED => 'Просмотрено',
        ];
    }

    public static function getStatusKeysString(): string
    {
        return implode(',', array_keys(self::statuses()));
    }
}
