<?php

declare(strict_types=1);

namespace App\Enum;

class PaymentMethodEnum
{
    const BANK_CARD = 0;
    const CASH_COURIER = 1;

    public static function methods(): array
    {
        return [
            self::BANK_CARD => 'Банковсвкие карты',
            self::CASH_COURIER => 'Наличные курьеру',
        ];
    }

    public static function getMethodKeysString(): string
    {
        return implode(',', array_keys(self::methods()));
    }
}
