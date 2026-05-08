<?php

namespace App\Support\Auth;

final class Access
{
    public const ROLES = [
        'admin' => [
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
        ]
    ];

    public static function permissions(): array
    {
        return collect(self::ROLES)
            ->flatten()
            ->unique()
            ->values()
            ->all();
    }
}
