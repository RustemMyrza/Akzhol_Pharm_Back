<?php

declare(strict_types=1);

namespace App\Enum;

class DeliveryTypeEnum
{
    const TO_ADDRESS = 0;
    const PICKUP = 1;

    public static function types(): array
    {
        return [
            self::TO_ADDRESS => 'До адресса',
            self::PICKUP => 'Самовывоз',
        ];
    }

    public static function getTypeKeysString(): string
    {
        return implode(',', array_keys(self::types()));
    }
}
