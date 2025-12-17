<?php

namespace App\Filament\Resources\AttributeOptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AttributeOptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('attribute.label')->label('Характеристика')->sortable()->toggleable(),
                TextColumn::make('label')->label('Название')->searchable()->sortable(),
                TextColumn::make('value')->label('Value')->searchable()->toggleable(),
                TextColumn::make('price_delta')->label('Δ₽')->sortable()->toggleable(),
                ToggleColumn::make('is_active')->label('Активна'),
                TextColumn::make('sort')->label('Сорт')->sortable()->toggleable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('sort');
    }
}
