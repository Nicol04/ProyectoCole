<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aula;
use App\Models\Curso;
class CursoController extends Controller
{
    
    public function index()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();

        $docente = null;
        if ($aula) {
            $docente = $aula->users()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'docente');
                })
                ->first();
        }
        $nombreDocente = $docente ? $docente->persona->nombre . ' ' . $docente->persona->apellido : 'No asignado';
        $cursos = $aula ? $aula->cursos : collect();
        return view('panel.cursos.index', compact('cursos', 'aula', 'nombreDocente'));
    }

}
