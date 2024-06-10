<?php

declare(strict_types=1);

namespace App\Enum;

class OrderStatusEnum
{
    const NEW = 0;
    const APPROVED = 1;
    const DECLINED = 2;
    const DEFERRED = 3;

    public static function statuses(): array
    {
        return [
            self::NEW => 'Новые',
            self::APPROVED => 'Одобренные',
            self::DECLINED => 'Отклоненные',
            self::DEFERRED => 'Отложенные',
        ];
    }

    public static function getStatusKeysString(): string
    {
        return implode(',', array_keys(self::statuses()));
    }

    public static function getStatusHtml(int $status): string
    {
        return match ($status) {
            self::APPROVED => '<span class="badge badge-success">' . self::statuses()[self::APPROVED] . '</span>',
            self::DECLINED => '<span class="badge badge-danger">' . self::statuses()[self::DECLINED] . '</span>',
            self::DEFERRED => '<span class="badge badge-warning">' . self::statuses()[self::DEFERRED] . '</span>',
            default => '<span class="badge badge-primary">' . self::statuses()[self::NEW] . '</span>'
        };
    }
}
