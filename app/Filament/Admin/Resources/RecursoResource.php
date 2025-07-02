<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RecursoResource\Pages;
use App\Filament\Admin\Resources\RecursoResource\RelationManagers;
use App\Models\Recurso;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecursoResource extends Resource
{
    use Translatable;
    protected static ?string $model = Recurso::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Gestión de documentos 3D';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curso_id')
                    ->label('Curso')
                    ->relationship('curso', 'curso')
                    ->required(),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextArea::make('descripcion')
                    ->required(),
                Forms\Components\Select::make('categoria_id')
                    ->label('Categoría')
                    ->relationship('categoria', 'nombre'),
                Forms\Components\FileUpload::make('imagen_preview')
                    ->image()
                    ->imageEditor()
                    ->directory('recursos')
                    ->disk('public')
                    ->label('Imagen del recurso'),
                Forms\Components\FileUpload::make('archivo')
                    ->label('Archivo 3D')
                    ->acceptedFileTypes([
                        'model/gltf-binary',
                        'application/octet-stream',
                        '.glb', '.gltf', '.obj'
                    ])
                    ->disk('public')
                    ->directory('temp')
                    ->visibility('private')
                    ->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                    ->enableDownload()
                    ->helperText('Si no subes un archivo nuevo, se conservará el actual.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curso.curso')
                    ->label('Curso'),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('descripcion')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('categoria.nombre')
                    ->label('Categoría')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('imagen_preview')
                    ->size(150)
                    ->label('Imagen del recurso'),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRecursos::route('/'),
            'create' => Pages\CreateRecurso::route('/create'),
            'edit' => Pages\EditRecurso::route('/{record}/edit'),
        ];
    }
}
