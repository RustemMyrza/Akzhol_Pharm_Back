<?php

declare(strict_types=1);

namespace App\Enum;

class NotificationMessageTypeEnum
{
    const NEWS = 'is_news';
    const SALES = 'is_sales';
    const PROMOTIONS = 'is_promotions';

    public static function types(): array
    {
        return [
            self::NEWS => 'Новости и магазин',
            self::SALES => 'Продажи',
            self::PROMOTIONS => 'Акции',
        ];
    }

    public static function getTypesKeysString(): string
    {
        return implode(',', array_keys(self::types()));
    }

}
