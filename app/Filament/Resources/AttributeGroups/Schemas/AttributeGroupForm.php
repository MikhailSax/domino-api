<?php

namespace App\Filament\Resources\AttributeGroups\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class AttributeGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Группа характеристик')
                ->schema([
                    Grid::make()->columns(['default' => 1, 'md' => 2])->schema([
                        TextInput::make('title')
                            ->label('Название')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug((string) $old)) return;
                                $set('slug', Str::slug((string) $state));
                            }),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        TextInput::make('sort')
                            ->label('Сортировка')
                            ->numeric()
                            ->default(100),

                        Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true),
                    ]),
                ]),
        ]);
    }
}
