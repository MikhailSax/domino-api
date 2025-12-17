<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Категория')
                ->schema([
                    Grid::make()
                        ->columns(['default' => 1, 'md' => 2])
                        ->schema([
                            TextInput::make('title')
                                ->label('Название')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                    // Не перетираем slug, если пользователь правил его руками:
                                    if (($get('slug') ?? '') !== Str::slug((string) $old)) {
                                        return;
                                    }

                                    $set('slug', Str::slug((string) $state));
                                }),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->maxLength(255)
                                ->helperText('Например: vizitki, listovki')
                                ->unique(ignoreRecord: true),

                            TextInput::make('sort')
                                ->label('Сортировка')
                                ->numeric()
                                ->default(100),

                            Toggle::make('is_active')
                                ->label('Активна')
                                ->default(true),
                        ]),

                    Textarea::make('options_schema')
                        ->label('Схема характеристик (JSON)')
                        ->rows(6)
                        ->helperText('Пока можно оставить пустым. Позже будем использовать для динамических характеристик.')
                        ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $state)
                        ->dehydrateStateUsing(function ($state) {
                            if (blank($state)) {
                                return null;
                            }
                            $decoded = json_decode((string) $state, true);
                            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
                        }),
                ]),
        ]);
    }
}
