<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Enums\PageStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->placeholder('Select a status')
                    ->options(PageStatus::class)
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
                Select::make('page_id')
                    ->label('Parent page')
                    ->placeholder("Select a parent page")
                    ->relationship('parent', 'title'),
                Select::make('user_id')
                    ->label('Author')
                    ->placeholder("Select an author")
                    ->relationship('author', 'name')
                    ->default(auth()->user()->id)
                    ->required(),
            ]);
    }
}
