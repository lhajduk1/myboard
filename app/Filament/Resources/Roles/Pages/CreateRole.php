<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Services\PermissionService;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function afterCreate(): void
    {
        $permissionNames = app(PermissionService::class)->syncPermissions($this->form);
        $this->record->syncPermissions($permissionNames);
    }
}
