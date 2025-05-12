<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $aula = $user->aulas()->first();
        $estudiantes = collect();
        if ($aula) {
            $estudiantes = $aula->users()
                ->whereHas('roles', function ($query) {
                    $query->where('name', 'estudiante');
                })
                ->with(['avatar', 'persona'])
                ->get();
        }
        return view('panel.estudiantes.index', compact('aula', 'estudiantes'));
    }
}
