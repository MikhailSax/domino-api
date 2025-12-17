<?php

namespace App\Filament\Resources\AttributeOptions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AttributeOptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Опция')
                ->schema([
                    Grid::make()->columns(['default' => 1, 'md' => 2])->schema([
                        Select::make('attribute_id')
                            ->label('Характеристика')
                            ->relationship('attribute', 'label')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('label')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('value')
                            ->label('Value (код)')
                            ->required()
                            ->rule('alpha_dash')
                            ->maxLength(64),

                        TextInput::make('price_delta')
                            ->label('Надбавка (₽)')
                            ->numeric()
                            ->default(0),

                        TextInput::make('sort')->label('Сортировка')->numeric()->default(100),
                        Toggle::make('is_active')->label('Активна')->default(true),
                    ]),
                ]),
        ]);
    }
}
