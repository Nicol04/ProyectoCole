<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AvatarUsuariosResource\Pages;
use App\Filament\Admin\Resources\AvatarUsuariosResource\RelationManagers;
use App\Models\Avatar_usuarios;
use App\Models\AvatarUsuarios;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\FormsComponent;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AvatarUsuariosResource extends Resource
{
    protected static ?string $model = Avatar_usuarios::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Avatar'; //NOMBRE O TITULO DEL BOTON

    protected static ?string $navigationGroup = 'Gestión de usuarios';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->label('Nombre del avatar'),
            Forms\Components\FileUpload::make('path')
                ->image()
                ->imageEditor()
                ->required()
                ->directory('avatares')
                ->disk('public')
                ->label('Imagen del avatar'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre del avatar'),
                Tables\Columns\ImageColumn::make('path')
                    ->disk('public')
                    ->label('Avatar')
                    ->size(150),
            ])
            ->filters([
                //
            ])
            ->actions([                
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAvatarUsuarios::route('/'),
            'create' => Pages\CreateAvatarUsuarios::route('/create'),
            'edit' => Pages\EditAvatarUsuarios::route('/{record}/edit'),
        ];
    }
}
