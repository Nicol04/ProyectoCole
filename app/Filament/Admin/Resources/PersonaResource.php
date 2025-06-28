<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PersonaResource\Pages;
use App\Filament\Admin\Resources\PersonaResource\RelationManagers;
use App\Models\Persona;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PersonaResource extends Resource
{
    use Translatable;
    protected static ?string $model = Persona::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Gestión de usuarios';
    protected static ?string $navigationLabel = 'Administrar personas';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('apellido')
                    ->required()
                    ->maxLength(60),
                Forms\Components\TextInput::make('dni')
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();

                if ($user->hasRole('admin')) {
                    // Si es admin, excluye admin y super_admin
                    $query->whereHas('user', function ($userQuery) {
                        $userQuery->whereDoesntHave('roles', function ($q) {
                            $q->whereIn('name', ['admin', 'super_admin']);
                        });
                    });
                } elseif ($user->hasRole('super_admin')) {
                    $query->whereHas('user', function ($userQuery) {
                    // Si es super_admin, excluye solo a otros super_admin
                    $userQuery->whereDoesntHave('roles', function ($q) {
                        $q->where('name', 'super_admin');
                        });
                    });
                }
            })
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genero')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPersonas::route('/'),
            'create' => Pages\CreatePersona::route('/create'),
            'edit' => Pages\EditPersona::route('/{record}/edit'),
        ];
    }
}
