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

    // Obtén el aula asociada al usuario
    $aula = $user->aulas()->first(); // Aquí buscamos la primera aula asociada

    // Si el aula existe, buscamos al docente
    $docente = null;
    if ($aula) {
        // Suponemos que el docente tiene el rol 'docente'
        $docente = $aula->users()
            ->whereHas('roles', function ($query) {
                $query->where('name', 'docente');
            })
            ->first(); // Tomamos el primer docente encontrado
    }

    // Acceder al nombre y apellido del docente
    $nombreDocente = $docente ? $docente->persona->nombre . ' ' . $docente->persona->apellido : 'No asignado';

    // Obtenemos los cursos disponibles
    $cursos = Curso::all(); // o puedes filtrar por el aula si lo necesitas

    return view('panel.cursos.index', compact('cursos', 'aula', 'nombreDocente'));
}

}
