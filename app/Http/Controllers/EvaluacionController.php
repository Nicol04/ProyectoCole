<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Sesion;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    public function index()
    {
        return view('panel.evaluaciones.index');
    }
    public function create()
    {
        $user = Auth::user();
        $cursos = collect();

        foreach ($user->aulas as $aula) {
            foreach ($aula->cursos as $curso) {
                $cursos->push($curso);
            }
        }
        $cursos = $cursos->unique('id');

        return view('panel.evaluaciones.create', compact('cursos'));
    }
    public function getSesionesPorCurso($cursoId)
    {
        $sesiones = Sesion::whereHas('aulaCurso', function ($query) use ($cursoId) {
        $query->where('curso_id', $cursoId);
        })->get();
        return response()->json($sesiones);
    }

}
