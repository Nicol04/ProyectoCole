<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Aula;
use App\Models\AulaCurso;
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

    public function sesiones(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $user = Auth::user();
        $aula = $user->aulas()->first();

        $aulaCurso = AulaCurso::where('curso_id', $id)
            ->where('aula_id', $aula->id)
            ->first();
        if (!$aulaCurso) {
            return view('panel.sesiones.index', compact('curso'))->with('error', 'No hay sesiones registradas.');
        }
        //$sesiones = $aulaCurso->sesiones()->orderBy('fecha', 'asc')->paginate(12);
            $sesiones = $aulaCurso->sesiones()
        ->orderBy('fecha', 'desc')
        ->paginate(12);

        return view('panel.sesiones.index', compact('curso', 'sesiones', 'aulaCurso'));
    }
    public function show($id)
    {
        $curso = Curso::findOrFail($id);
        $user = Auth::user();
        $aula = $user->aulas()->first();
        
        // Obtener información del docente
        $docente = null;
        if ($aula) {
            $docente = $aula->users()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'docente');
                })
                ->first();
        }
        $nombreDocente = $docente ? $docente->persona->nombre . ' ' . $docente->persona->apellido : 'No asignado';
        
        // Obtener el aulaCurso para acceder a sesiones y otros datos
        $aulaCurso = AulaCurso::where('curso_id', $id)
            ->where('aula_id', $aula->id)
            ->first();
            
        return view('panel.cursos.show', compact('curso', 'aula', 'nombreDocente', 'aulaCurso'));
    }
}
