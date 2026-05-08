<?php

namespace App\Filament\Resources\Roles\Schemas;

use Filament\Forms\Components\{TextInput, CheckboxList};
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('guard_name')
                    ->required(),
                Section::make('Permissions')
                    ->schema([
                        ...self::permissionCheckboxLists(),
                    ])
                    ->columnSpan(2)
                    ->columns(4),

            ]);
    }

    private static function permissionCheckboxLists(): array
    {
        return Permission::query()
            ->orderBy('name')
            ->pluck('name')
            ->groupBy(fn(string $permission) => str($permission)->before('.')->toString())
            ->map(
                fn(Collection $permissions, string $group) => CheckboxList::make("permissions_{$group}")
                    ->label(str($group)->headline())
                    ->options(
                        $permissions
                            ->mapWithKeys(fn(string $permission) => [
                                $permission => str($permission)->after('.')->headline()->toString(),
                            ])
                            ->toArray()
                    )
                    ->afterStateHydrated(function (CheckboxList $component, $record) use ($group) {
                        if (! $record) {
                            return;
                        }

                        $component->state(
                            $record->permissions
                                ->pluck('name')
                                ->filter(fn(string $permission) => str($permission)->startsWith("{$group}."))
                                ->values()
                                ->toArray()
                        );
                    })
                    ->bulkToggleable()
                    ->dehydrated(false)
            )
            ->values()
            ->toArray();
    }
}
