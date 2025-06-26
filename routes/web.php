<?php

use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\ComunicadoController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ExamenPreguntaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\RespuestaEstudianteController;
use App\Http\Controllers\SesionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// parte informativa
Route::get('/', function () {
    return view('public.index');
})->name('public.index');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

Route::get('/panel', function () {
    return view('panel.login');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login')->with('mensaje', 'Sesión cerrada exitosamente')->with('icono', 'success');
})->name('logout');

Route::middleware(['auth'])->group(function () {
Route::get('/panel/index', function () {
        return view('panel.index');
    })->name('index');

Route::get('/panel/cursos', [CursoController::class, 'index'])->name('panel.cursos');

//Ruta de los estudiantes
Route::get('/panel/estudiantes', [UserController::class, 'index'])->name('estudiantes.index');
//Ruta de informacion de estudiantes
Route::get('/panel/estudiantes/{id}', [UserController::class, 'show'])->name('estudiantes.show');

Route::get('/users/exportar',[UserController::class,'exportarUsuarios'])->name('users.exportarUsuarios');
Route::get('/users/perfil',[UserController::class,'perfil'])->name('users.perfil');
Route::get('/users/perfil/{id}/edit', [UserController::class, 'editarAvatar'])->name('users.avatar.edit');
Route::post('/users/perfil/{id}/update', [UserController::class, 'actualizarAvatar'])->name('user.avatar.update');

Route::get('/cursos/{id}', [CursoController::class, 'sesiones'])->name('sesiones.index');
Route::get('cursos/sesion/create', [SesionController::class, 'create'])->name('sesiones.create');
Route::post('cursos/sesion', [SesionController::class, 'store'])->name('sesiones.store');
Route::get('cursos/sesion/{id}', [SesionController::class, 'show'])->name('sesiones.show');
Route::get('cursos/sesion/{id}/editar', [SesionController::class, 'edit'])->name('sesiones.edit');
Route::get('cursos/sesion/{id}/ver', [SesionController::class, 'show'])->name('sesiones.show');
Route::put('cursos/sesion/{id}', [SesionController::class, 'update'])->name('sesiones.update');

Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
Route::get('/recursos/{id}', [RecursoController::class, 'show'])->name('recursos.show');

Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluacion.index');

Route::get('/evaluaciones/create', [EvaluacionController::class, 'create'])->name('evaluacion.create');
Route::get('/evaluaciones/create-sesion', [EvaluacionController::class, 'create_sesion'])->name('evaluacion.create.sesion');
Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('evaluacion.store');

Route::put('/evaluacion/{id}/actualizar', [EvaluacionController::class, 'actualizar'])->name('evaluacion.actualizar');

Route::get('/sesiones/por-curso/{curso}', [EvaluacionController::class, 'getSesionesPorCurso']);

Route::get('/evaluacion/{id}/generarexamen', [ExamenPreguntaController::class, 'generarExamen'])->name('evaluaciones.generarExamen');
Route::get('/formulario_examen',[ExamenPreguntaController::class, 'formulario'])->name('examen.formulario_examen');

Route::get('/examen/renderizar', [ExamenPreguntaController::class, 'renderizar'])->name('examen.renderizar');

Route::post('/examen/guardar',[ExamenPreguntaController::class, 'store'])->name('examen.guardar');
Route::put('/examen/{examenPregunta}/actualizar', [ExamenPreguntaController::class, 'update'])->name('examen.actualizar');

Route::get('/evaluacion/{evaluacion_id}/examen', [ExamenPreguntaController::class, 'show'])->name('evaluaciones.examen');
Route::delete('/evaluacion/{evaluacion}', [EvaluacionController::class, 'destroy'])->name('evaluaciones.eliminar');
Route::delete('/sesion/{sesion}', [SesionController::class, 'destroy'])->name('sesiones.eliminar');
Route::get('/examen/{examenPregunta}/editar', [ExamenPreguntaController::class, 'edit'])->name('examen.editar');

//Promedio de calificaciones:
Route::get('/calificaciones/{id}', [CalificacionController::class, 'index'])->name('calificacion.index');
//Exportar calificaciones de estudiante:
Route::get('/panel/estudiantes/{id}/exportar', [UserController::class, 'exportarCalificacionesEstudiante'])->name('estudiantes.exportarCalificaciones');
//Ver calificaciones de todos los estudiantes:
Route::get('/calificaciones', [CalificacionController::class, 'show'])->name('calificacion.show');

Route::get('/evaluacion/{id}/iniciar', [EvaluacionController::class, 'iniciar'])->name('evaluacion.iniciar');
Route::get('/examen/estudiantes', [ExamenPreguntaController::class, 'mostrarExamenEstudiante'])->name('examen.estudiantes');
Route::post('/respuesta-estudiante', [RespuestaEstudianteController::class, 'store'])->name('respuesta_estudiante.store');
Route::get('/examen/revision/{intento_id}', [RespuestaEstudianteController::class, 'revision'])->name('examen.revision');

Route::delete('/intentos/{id}', [RespuestaEstudianteController::class, 'destroy'])->name('intentos.destroy');

Route::get('/retroalimentacion', function () {return view('panel.ia.retroalimentacion');})->name('retroalimentacion');

//REPORTES:
Route::get('/reporte/historial-estudiantes', [RespuestaEstudianteController::class, 'exportarHistorialEstudiantes'])->name('reporte.historial.estudiantes');
//Comunicados:
Route::get('/comunicados', [ComunicadoController::class, 'index'])->name('comunicados.index');
Route::get('/comunicados/create', [ComunicadoController::class, 'create'])->name('comunicados.create');
Route::post('/comunicados', [ComunicadoController::class, 'store'])->name('comunicados.store');
Route::get('/comunicados/{comunicado}/edit', [ComunicadoController::class, 'edit'])->name('comunicados.edit');
Route::put('/comunicados/{comunicado}', [ComunicadoController::class, 'update'])->name('comunicados.update');
Route::delete('/comunicados/{comunicado}', [ComunicadoController::class, 'destroy'])->name('comunicados.destroy');
Route::post('/comunicados/{comunicado}/visto', [ComunicadoController::class, 'marcarVisto'])->name('comunicados.visto');
Route::get('/informativa', [ComunicadoController::class, 'informativa'])->name('informativa');


});