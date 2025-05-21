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
    // Iniciar la consulta base
    $recursos = Recurso::query();

    // Filtro búsqueda por nombre
    if ($request->filled('buscar')) {
        $recursos->where('nombre', 'like', '%' . $request->buscar . '%');
    }

    // Filtro por categoría si viene en la request
    if ($request->filled('categoria')) {
        $recursos->where('categoria_id', $request->categoria);
    }

    // Filtro por curso si viene en la request
    if ($request->filled('curso')) {
        $recursos->where('curso_id', $request->curso);
    }

    // Obtener los resultados (puedes usar paginate si quieres)
    $recursos = $recursos->get();

    // Obtener datos para filtros laterales
    $cursos = Curso::withCount('recursos')->get();
    $categorias = Categoria::withCount('recursos')->get();

    // Pasar variables a la vista
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
