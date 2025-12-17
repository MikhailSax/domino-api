<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Заказ')
                ->schema([
                    Grid::make()
                        ->columns(['default' => 1, 'md' => 2])
                        ->schema([
                            TextInput::make('user_id')
                                ->label('User ID')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),

                            Select::make('status')
                                ->label('Статус')
                                ->options([
                                    'new' => 'Новый',
                                    'paid' => 'Оплачен',
                                    'in_work' => 'В работе',
                                    'done' => 'Готов',
                                    'canceled' => 'Отменён',
                                ])
                                ->required(),

                            TextInput::make('total')
                                ->label('Сумма (₽)')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false),
                        ]),

                    Textarea::make('comment')
                        ->label('Комментарий менеджера')
                        ->rows(4),
                ]),
        ]);
    }
}
