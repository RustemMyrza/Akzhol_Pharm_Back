<?php

declare(strict_types=1);

namespace App\Enum;

class PaymentStatusEnum
{
    const NEW = 0;
    const PAYED = 1;
    const FAILED = 2;

    public static function statuses(): array
    {
        return [
            self::NEW => 'Новый',
            self::PAYED => 'Успешно',
            self::FAILED => 'Ошибка оплаты',
        ];
    }

    public static function getStatusKeysString(): string
    {
        return implode(',', array_keys(self::statuses()));
    }
}
