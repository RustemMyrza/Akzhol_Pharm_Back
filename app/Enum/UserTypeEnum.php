<?php

declare(strict_types=1);

namespace App\Enum;

class UserTypeEnum
{
    const INDIVIDUAL = 0;
    const ENTITY = 1;

    public static function types(): array
    {
        return [
            self::INDIVIDUAL => 'Физическое лицо',
            self::ENTITY => 'Юридическое лицо',
        ];
    }

    public static function getTypeKeysString(): string
    {
        return implode(',', array_keys(self::types()));
    }
}
