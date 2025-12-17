<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Товар')
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
                                    if (($get('slug') ?? '') !== Str::slug((string) $old)) {
                                        return;
                                    }
                                    $set('slug', Str::slug((string) $state));
                                }),

                            TextInput::make('slug')
                                ->label('Slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true),

                            Select::make('category_id')
                                ->label('Категория')
                                ->relationship('category', 'title')
                                ->searchable()
                                ->preload()
                                ->required(),

                            TextInput::make('price_from')
                                ->label('Базовая цена (₽)')
                                ->numeric()
                                ->required(),

                            Toggle::make('is_active')
                                ->label('Активен')
                                ->default(true),

                            TextInput::make('image_url')
                                ->label('URL картинки (пока заглушка)')
                                ->maxLength(2048)
                                ->columnSpanFull(),
                        ]),

                    Textarea::make('short_description')
                        ->label('Короткое описание')
                        ->rows(3)
                        ->columnSpanFull(),

                    RichEditor::make('description')
                        ->label('Описание')
                        ->columnSpanFull(),

                    Textarea::make('options_override')
                        ->label('Переопределение характеристик (JSON)')
                        ->rows(6)
                        ->helperText('Если нужно переопределить схему/поля для конкретного товара.')
                        ->formatStateUsing(fn ($state) => is_array($state) ? json_encode($state, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : $state)
                        ->dehydrateStateUsing(function ($state) {
                            if (blank($state)) {
                                return null;
                            }
                            $decoded = json_decode((string) $state, true);
                            return json_last_error() === JSON_ERROR_NONE ? $decoded : null;
                        })
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
