<?php

namespace App\Filament\Admin\Resources\AulaResource\RelationManagers;

use App\Models\Año;
use App\Models\User;
use App\Models\usuario_aula;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Actions\DetachAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';
    
    protected static ?string $title = 'Usuarios del Aula';
    protected static ?string $modelLabel = 'Usuario';
    protected static ?string $pluralModelLabel = 'Usuarios';

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
            ->modifyQueryUsing(fn($query) => $query->with('persona', 'roles'))
            ->columns([
                Tables\Columns\TextColumn::make('persona.nombre')->label('Nombre'),
                Tables\Columns\TextColumn::make('persona.apellido')->label('Apellido'),
                Tables\Columns\TextColumn::make('roles.name')->label('Rol')
                    ->formatStateUsing(fn($state) => ucfirst($state)),
            ])
            ->headerActions([
                Action::make('agregarUsuarios')
                    ->label('Agregar Estudiantes o Docente')
                    ->icon('heroicon-m-user-plus')
                    ->form([
                        Forms\Components\Select::make('user_ids')
                            ->label('Seleccionar usuarios')
                            ->multiple()
                            ->searchable()
                            ->options(function (RelationManager $livewire) {
                                $aula = $livewire->getOwnerRecord();

                                // Verificar si ya hay un docente en el aula
                                $yaTieneDocente = $aula->users()
                                    ->whereHas('roles', fn($q) => $q->where('name', 'docente'))
                                    ->exists();

                                return User::whereDoesntHave('usuario_aulas') // no tiene aulas
                                    ->whereHas('roles', function ($query) use ($yaTieneDocente) {
                                        $query->whereIn('name', $yaTieneDocente ? ['estudiante'] : ['estudiante', 'docente']);
                                    })
                                    ->with('persona')
                                    ->get()
                                    ->mapWithKeys(fn($user) => [
                                        $user->id => "{$user->persona?->nombre} {$user->persona?->apellido}",
                                    ]);
                            })
                            ->required(),
                    ])
                    ->action(function (array $data, RelationManager $livewire) {
                        $aula = $livewire->getOwnerRecord();

                        $año = Año::whereDate('fecha_inicio', '<=', now())
                            ->whereDate('fecha_fin', '>=', now())
                            ->first();

                        if (! $año) {
                            Notification::make()
                                ->title('No hay un año activo definido.')
                                ->danger()
                                ->send();
                            return;
                        }

                        foreach ($data['user_ids'] as $userId) {
                            usuario_aula::create([
                                'user_id' => $userId,
                                'aula_id' => $aula->id,
                                'año_id' => $año->id,
                            ]);
                        }

                        $aula->actualizarCantidadUsuarios();

                        Notification::make()
                            ->title('Usuarios vinculados exitosamente.')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Action::make('desvincular')
                    ->label('Desvincular')
                    ->color('danger')
                    ->icon('heroicon-m-trash')
                    ->requiresConfirmation()
                    ->action(function ($record, RelationManager $livewire) {
                        $aula = $livewire->getOwnerRecord();

                        $año = Año::whereDate('fecha_inicio', '<=', now())
                            ->whereDate('fecha_fin', '>=', now())
                            ->first();

                        if (! $año) {
                            Notification::make()
                                ->title('No hay un año activo definido.')
                                ->danger()
                                ->send();
                            return;
                        }

                        usuario_aula::where('user_id', $record->id)
                            ->where('aula_id', $aula->id)
                            ->where('año_id', $año->id)
                            ->delete();

                        $aula->actualizarCantidadUsuarios();

                        Notification::make()
                            ->title('Usuario desvinculado correctamente.')
                            ->success()
                            ->send();
                    }),
            ]);
    }
}
