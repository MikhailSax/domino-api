<?php


namespace App\Filament\Resources\Attributes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AttributeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Характеристика')
                ->schema([
                    Grid::make()->columns(['default' => 1, 'md' => 2])->schema([
                        Select::make('attribute_group_id')
                            ->label('Группа')
                            ->relationship('group', 'title')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('key')
                            ->label('Key (код)')
                            ->helperText('Например: paper, size, lamination')
                            ->required()
                            ->rule('alpha_dash')
                            ->maxLength(64),

                        TextInput::make('label')
                            ->label('Название')
                            ->required()
                            ->maxLength(255),

                        Select::make('type')
                            ->label('Тип')
                            ->required()
                            ->options([
                                'select' => 'select',
                                'number' => 'number',
                                'text' => 'text',
                                'bool' => 'bool',
                                'file' => 'file',
                            ])
                            ->default('select'),

                        Toggle::make('is_required')->label('Обязательное')->default(false),
                        Toggle::make('is_active')->label('Активно')->default(true),

                        TextInput::make('sort')->label('Сортировка')->numeric()->default(100),
                    ]),

                    Textarea::make('meta')
                        ->label('Meta (JSON)')
                        ->rows(5)
                        ->helperText('Например: {"min":1,"max":1000,"step":50}')
                        ->formatStateUsing(fn($state) => is_array($state) ? json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $state)
                        ->dehydrateStateUsing(function ($state) {
                            if (blank($state)) return null;
                            $decoded = json_decode((string)$state, true);
                            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
                        })
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
