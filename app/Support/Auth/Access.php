<?php

namespace App\Support\Auth;

final class Access
{
    public const ROLES = [
        'admin' => [
            'dashboard.view',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
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
