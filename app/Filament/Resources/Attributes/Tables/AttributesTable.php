<?php

namespace App\Filament\Resources\Attributes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class AttributesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('#')->sortable(),
                TextColumn::make('group.title')->label('Группа')->sortable()->toggleable(),
                TextColumn::make('label')->label('Название')->searchable()->sortable(),
                TextColumn::make('key')->label('Key')->searchable()->toggleable(),
                TextColumn::make('type')->label('Тип')->toggleable(),
                ToggleColumn::make('is_required')->label('Req')->toggleable(),
                ToggleColumn::make('is_active')->label('Активно'),
                TextColumn::make('sort')->label('Сорт')->sortable()->toggleable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('sort');
    }
}
