<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use App\Services\PermissionService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->visible(fn() => auth()->user()->can('roles.delete')),
            ForceDeleteAction::make()
                ->requiresConfirmation()
                ->visible(fn() => auth()->user()->can('roles.delete')),
        ];
    }

    protected function afterSave(): void
    {
        $permissionNames = app(PermissionService::class)->syncPermissions($this->form);
        $this->record->syncPermissions($permissionNames);
    }
}
