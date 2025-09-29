<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CriterioEvaluacionResource\Pages;
use App\Filament\Admin\Resources\CriterioEvaluacionResource\RelationManagers;
use App\Models\CriterioEvaluacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CriterioEvaluacionResource extends Resource
{
    protected static ?string $model = CriterioEvaluacion::class;
    protected static ?string $navigationGroup = 'Currículo';
    protected static ?string $navigationLabel = 'Criterios de evaluación';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCriterioEvaluacions::route('/'),
            'create' => Pages\CreateCriterioEvaluacion::route('/create'),
            'edit' => Pages\EditCriterioEvaluacion::route('/{record}/edit'),
        ];
    }
}
