<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EnfoqueTransversalResource\Pages;
use App\Filament\Admin\Resources\EnfoqueTransversalResource\RelationManagers;
use App\Models\EnfoqueTransversal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EnfoqueTransversalResource extends Resource
{
    protected static ?string $model = EnfoqueTransversal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                ->label('Nombre del Enfoque')
                ->required()
                ->maxLength(255),

            Forms\Components\Builder::make('valores_actitudes')
                ->label('Valores y Actitudes')
                ->blocks([
                    Forms\Components\Builder\Block::make('valor_actitud')
                        ->schema([
                            Forms\Components\TextInput::make('Valores')
                                ->label('Valores')
                                ->required(),
                            Forms\Components\Textarea::make('Actitudes')
                                ->label('Actitudes')
                                ->rows(3)
                                ->required(),
                        ])
                        ->columns(2)
                        ->label('Valores y Actitudes'),
                ])
                ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nombre')
                ->label('Nombre del Enfoque')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('valores_actitudes')
                ->label('Cantidad de valores/actitudes')
                ->getStateUsing(fn($record) => is_array($record->valores_actitudes) ? count($record->valores_actitudes) : 0),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListEnfoqueTransversals::route('/'),
            'create' => Pages\CreateEnfoqueTransversal::route('/create'),
            'edit' => Pages\EditEnfoqueTransversal::route('/{record}/edit'),
        ];
    }
}
