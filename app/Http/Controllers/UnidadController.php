<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Unidad;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function create()
    {
        $docente = Auth::user();

        // Obtener el grado del docente autenticado (según su aula)
        $grado = $docente->usuario_aulas()->first()?->aula?->grado ?? 'Sin grado';

        // Buscar docentes del mismo grado (excepto el actual)
        $aulasIds = Aula::where('grado', $grado)->pluck('id');

        $docentes = User::whereHas('usuario_aulas', function ($q) use ($aulasIds) {
                $q->whereIn('aula_id', $aulasIds);
            })
            ->whereHas('roles', fn($r) => $r->where('name', 'docente'))
            ->where('id', '!=', $docente->id)
            ->with('persona')
            ->get()
            ->mapWithKeys(function ($user) {
                $persona = $user->persona;
                $nombreCompleto = trim(($persona?->nombre ?? '') . ' ' . ($persona?->apellido ?? ''));
                return [$user->id => $nombreCompleto ?: 'Docente sin nombre'];
            });

        return view('panel.unidades.create', compact('grado', 'docentes'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|max:255',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date',
        'grado' => 'required|string|max:255',
        'profesores_responsables' => 'required|array|min:1',
        'situacion_significativa' => 'required|string',
        'productos' => 'required|string',
    ]);

    $docenteAuth = Auth::user();
    $profesores = $request->profesores_responsables;
    $profesores[] = $docenteAuth->id; // también incluir al docente actual

    // 🔹 Obtener las secciones correspondientes a cada docente
    $secciones = \App\Models\User::whereIn('id', $profesores)
        ->with('usuario_aulas.aula')
        ->get()
        ->flatMap(fn($u) => $u->usuario_aulas->pluck('aula.seccion'))
        ->unique()
        ->values()
        ->toArray();

    Unidad::create([
        'nombre' => $request->nombre,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'grado' => $request->grado,
        'profesores_responsables' => $profesores,
        'secciones' => $secciones,
        'situacion_significativa' => $request->situacion_significativa,
        'productos' => $request->productos,
    ]);

    return redirect()->back()
        ->with('mensaje', 'Unidad creada correctamente.')
        ->with('icono', 'success');
}


}
