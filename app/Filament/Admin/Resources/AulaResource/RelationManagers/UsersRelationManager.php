<?php

namespace App\Filament\Admin\Resources\AulaResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('persona', 'roles')) // 👈 importante
        ->columns([
            Tables\Columns\TextColumn::make('name')->label('Usuario'),
            Tables\Columns\TextColumn::make('persona.nombre')->label('Nombre'),
            Tables\Columns\TextColumn::make('persona.apellido')->label('Apellido'),
            Tables\Columns\TextColumn::make('roles.name') // primera coincidencia del plugin Shield
                ->label('Rol')
                ->formatStateUsing(fn ($state) => ucfirst($state)), // Muestra "Estudiante", "Docente", etc.
        ])
            ->actions([
                Tables\Actions\DetachAction::make(),
            ]);
    }
}
