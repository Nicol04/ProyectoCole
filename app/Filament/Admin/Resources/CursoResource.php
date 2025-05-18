<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CursoResource\Pages;
use App\Filament\Admin\Resources\CursoResource\RelationManagers;
use App\Filament\Imports\CursoImporter;
use App\Models\Aula;
use App\Models\Curso;
use Filament\Actions\ImportAction;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CursoResource extends Resource
{
    protected static ?string $model = Curso::class;

    protected static ?string $navigationIcon = 'heroicon-o-square-3-stack-3d';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información General')
                    ->columns(3)
                    ->description('Cursos.')
                    ->schema([
                        Forms\Components\TextInput::make('curso')
                            ->required()
                            ->maxLength(60),

                        Forms\Components\Textarea::make('descripcion')
                            ->columnSpan(2),
                        Forms\Components\FileUpload::make('image_url')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->directory('cursos')
                            ->disk('public')
                            ->label('Imagen del curso'),
                    ]),

                    Select::make('aulas')
                    ->multiple()
                    ->relationship('aulas', 'grado_seccion')
                    ->getOptionLabelFromRecordUsing(fn (Aula $record) => $record->grado_seccion)
                    ->searchable()
                    ->preload()
                    ->placeholder('Selecciona usuarios'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('curso')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_url')
                    ->size(150)
                    ->label('Imagen del curso'),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable()
                    ->limit(50)
                    ->label('Descripción'),
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
            'index' => Pages\ListCursos::route('/'),
            'create' => Pages\CreateCurso::route('/create'),
            'edit' => Pages\EditCurso::route('/{record}/edit'),
        ];
    }
}
