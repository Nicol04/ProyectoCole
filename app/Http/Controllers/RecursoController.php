<?php

namespace App\Http\Controllers;

use App\Models\Recurso;
use Illuminate\Http\Request;
use App\Models\Curso;

class RecursoController extends Controller
{
    public function index()
    {
        $recursos = \App\Models\Recurso::all();
        $cursos = Curso::withCount('recursos')->get();
        return view('panel.recursos.index', compact('recursos', 'cursos'));
    }
    public function show($id)
    {
        $recurso = Recurso::with('curso')->findOrFail($id);
        return view('panel.recursos.show', compact('recurso'));
    }
}
