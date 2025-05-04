<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Administrar usuarios';
    protected static ?string $navigationGroup = 'Gestión de usuarios';
    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos de la Persona')
                    ->description('Datos personales.')
                    ->schema([
                        Fieldset::make()
                            ->relationship('persona')
                            ->columns(3)
                            ->schema([
                                TextInput::make('nombre')
                                    ->required()
                                    ->maxLength(60)
                                    ->live(),
                                TextInput::make('apellido')
                                    ->required()
                                    ->maxLength(60)
                                    ->live(),
                                TextInput::make('dni')
                                    ->required()
                                    ->maxLength(8)
                                    ->minLength(8)
                                    ->rules(['regex:/^[0-9]{8}$/'])
                                    ->validationMessages([
                                        'regex' => 'El DNI debe contener exactamente 8 dígitos numéricos.',
                                    ]),
                                Radio::make('genero')
                                    ->options([
                                        'Masculino' => 'Masculino',
                                        'Femenino' => 'Femenino',
                                    ])
                                    ->inline()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Forms\Components\Section::make('Información General')
                    ->columns(3)
                    ->description('Datos principales de usuario.')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->disabled()
                            ->maxLength(20)
                            ->dehydrated(true)
                            ->label('Nombre de usuario'),

                            \Filament\Forms\Components\Actions::make([
                                \Filament\Forms\Components\Actions\Action::make('Generar nombre')
                                    ->icon('heroicon-o-arrow-path')
                                    ->action(function ($get, $set) {
                                        $nombre = $get('persona.nombre');
                                        $apellidoCompleto = $get('persona.apellido');
                            
                                        if ($nombre && $apellidoCompleto) {
                                            $dosLetra = substr($nombre, 0, 1);
                                            $apellidoPaterno = strtok($apellidoCompleto, ' ');
                                            $apellidoMaternoCompleto = trim(strrchr($apellidoCompleto, ' '));
                                            $apellidoMaterno = substr($apellidoMaternoCompleto, 0, 2);
                            
                                            $username = ucfirst(strtolower($dosLetra . $apellidoPaterno . $apellidoMaterno));
                            
                                            $set('name', $username);
                                        }
                                    }),
                                ]),
                            
                        TextInput::make('email')
                            ->email()
                            ->maxLength(40),

                        Select::make('avatar_usuario_id')
                            ->label('Seleccionar Avatar')
                            ->relationship('avatar', 'name')
                            ->searchable()
                            ->options(function () {
                                return \App\Models\Avatar_usuarios::all()->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(function ($state, $get, $set) {
                                if ($state) {
                                    $avatar = \App\Models\Avatar_usuarios::find($state);
                                    $set('avatar_usuario.path', $avatar->path);
                                }
                            }),

                        TextInput::make('password')
                            ->password()
                            ->required()
                            ->maxLength(10),

                        Select::make('estado')
                            ->required()
                            ->options([
                                'Activo' => 'Activo',
                                'Inactivo' => 'Inactivo',
                            ]),
                    ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('persona.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('avatar_usuario_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
