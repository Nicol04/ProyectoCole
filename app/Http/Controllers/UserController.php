<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
    public function exportarUsuarios()
    {
        return Excel::download(new ExportUser, 'usuarios.xlsx');
    }
}
