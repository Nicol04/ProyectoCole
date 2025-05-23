<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Recurso;
use Illuminate\Http\Request;
use App\Models\Curso;

class RecursoController extends Controller
{
    public function index(Request $request)
    {
        $recursos = Recurso::query();
        if ($request->filled('buscar')) {
            $recursos->where('nombre', 'like', '%' . $request->buscar . '%');
        }
        if ($request->filled('categoria')) {
            $recursos->where('categoria_id', $request->categoria);
        }
        if ($request->filled('curso')) {
            $recursos->where('curso_id', $request->curso);
        }
        $recursos = $recursos->get();
        $cursos = Curso::withCount('recursos')->get();
        $categorias = Categoria::withCount('recursos')->get();

        return view('panel.recursos.index', [
            'recursos' => $recursos,
            'cursos' => $cursos,
            'categorias' => $categorias,
            'categoriaId' => $request->categoria,
            'cursoId' => $request->curso,
            'buscar' => $request->buscar,
        ]);
    }

    public function show($id)
    {
        $recurso = Recurso::with('curso')->findOrFail($id);
        return view('panel.recursos.show', compact('recurso'));
    }
}
