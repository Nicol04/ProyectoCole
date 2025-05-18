<?php

namespace App\Observers;

use App\Models\Aula;
use App\Models\usuario_aula;

class UsuarioAulaObserver
{
    /**
     * Handle the UsuarioAula "created" event.
     */
    public function created(usuario_aula $usuarioAula): void
    {
        self::actualizarCantidad($usuarioAula->aula_id);
    }

    /**
     * Handle the UsuarioAula "updated" event.
     */
    public function updated(usuario_aula $usuarioAula): void
    {
        if ($usuarioAula->wasChanged('aula_id')) {
            self::actualizarCantidad($usuarioAula->getOriginal('aula_id'));
            self::actualizarCantidad($usuarioAula->aula_id);
        }
    }

    /**
     * Handle the UsuarioAula "deleted" event.
     */
    public function deleted(usuario_aula $usuarioAula): void
    {
        self::actualizarCantidad($usuarioAula->aula_id);
    }

    private static function actualizarCantidad($aulaId)
    {
        $aula = Aula::find($aulaId);
        if ($aula) {
            $aula->cantidad_usuarios = $aula->users()->count();
            $aula->save();
        }
    }

    /**
     * Handle the UsuarioAula "restored" event.
     */
    public function restored(usuario_aula $usuarioAula): void
    {
        //
    }

    /**
     * Handle the UsuarioAula "force deleted" event.
     */
    public function forceDeleted(usuario_aula $usuarioAula): void
    {
        //
    }
}
