<?php

namespace App\Services;

use Filament\Schemas\Schema;

class PermissionService
{
    public function syncPermissions(Schema $form): array
    {
        return collect($form->getRawState())
            ->filter(fn($value, string $key) => str($key)->startsWith('permissions_'))
            ->flatten()
            ->unique()
            ->values()
            ->all();
    }
}
