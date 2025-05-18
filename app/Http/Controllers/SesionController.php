<?php

namespace App\Http\Controllers;

use App\Models\AulaCurso;
use App\Models\Sesion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SesionController extends Controller
{
    public function create()
    {
        return view('panel.sesiones.create');
    }
    public function show($id)
    {
        $sesion = Sesion::with('aulaCurso.curso')->findOrFail($id);
        return view('panel.sesiones.show', compact('sesion'));
    }
    public function edit($id)
    {
        $sesion = Sesion::findOrFail($id);
        return view('panel.sesiones.edit', compact('sesion'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'titulo' => 'required|string',
            'objetivo' => 'nullable|string',
            'actividades' => 'nullable|string',
        ]);

        $sesion = Sesion::findOrFail($id);
        $fecha = Carbon::parse($request->fecha);
        $dia = ucfirst($fecha->locale('es')->isoFormat('dddd'));

        $sesion->update([
            'fecha' => $request->fecha,
            'dia' => $dia,
            'titulo' => $request->titulo,
            'objetivo' => $request->objetivo,
            'actividades' => $request->actividades,
        ]);
        return redirect()->route('sesiones.show', $id)
        ->with('mensaje', 'Sesión actualizada exitosamente')
        ->with('icono', 'success');
    }
}
