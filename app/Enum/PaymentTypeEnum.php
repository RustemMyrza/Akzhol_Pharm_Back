<?php

declare(strict_types=1);

namespace App\Enum;

class PaymentTypeEnum
{
    const HALYK = 0;
    const KASPI = 1;

    public static function types(): array
    {
        return [
            self::HALYK => 'HALYK',
            self::KASPI => 'KASPI',
        ];
    }

    public static function getTypeKeysString(): string
    {
        return implode(',', array_keys(self::types()));
    }
}
