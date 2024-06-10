<?php

namespace App\Traits;

trait HasUserRoles
{
    public static function adminRoles(): array
    {
        $developerRole = [];
        if (auth()->user()->hasRole('developer')) {
            $developerRole = [
                'developer' => 'Разработчик',
            ];
        }
        return [
                'user' => 'Пользователь',
                'admin' => 'Админстратор',
                'manager' => 'Менеджер',
            ] + $developerRole;
    }

    public static function adminRolesKeys(): string
    {
        return implode(',', array_keys(self::adminRoles()));
    }

    public static function getRolesForUser(): array
    {
        if (auth()->user()->hasRole(['developer'])) {
            return ['developer', 'admin', 'manager', 'user'];
        }
        return ['admin', 'manager', 'user'];
    }
}
