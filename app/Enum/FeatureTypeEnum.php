<?php

declare(strict_types=1);

namespace App\Enum;

class FeatureTypeEnum
{
    const SELECTABLE = 0;
    const RANGE = 1;

    public static function types(): array
    {
        return [
            self::SELECTABLE => 'Выбираемый',
            self::RANGE => 'Диапазон',
        ];
    }

    public static function getTypeKeysString(): string
    {
        return implode(',', array_keys(self::types()));
    }
}
