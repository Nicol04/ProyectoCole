<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DesempenoResource\Pages;
use App\Filament\Admin\Resources\DesempenoResource\RelationManagers;
use App\Models\Desempeno;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DesempenoResource extends Resource
{
    protected static ?string $model = Desempeno::class;
    protected static ?string $navigationGroup = 'Currículo';
    protected static ?string $navigationLabel = 'Desempeños';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('grado')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('descripcion')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('criterio_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grado')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDesempenos::route('/'),
            'create' => Pages\CreateDesempeno::route('/create'),
            'edit' => Pages\EditDesempeno::route('/{record}/edit'),
        ];
    }
}
