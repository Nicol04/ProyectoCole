<?php
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecursoController;
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
Route::get('/panel/estudiantes', [UserController::class, 'index'])->name('estudiantes.index');
Route::get('/users/exportar',[UserController::class,'exportarUsuarios'])->name('users.exportarUsuarios');
Route::get('/users/perfil',[UserController::class,'perfil'])->name('users.perfil');
Route::get('/users/perfil/{id}/edit', [UserController::class, 'editarAvatar'])->name('users.avatar.edit');
Route::post('/users/perfil/{id}/update', [UserController::class, 'actualizarAvatar'])->name('user.avatar.update');

Route::get('/cursos/{id}', [CursoController::class, 'sesiones'])->name('sesiones.index');
Route::get('cursos/sesion', [SesionController::class, 'create'])->name('sesiones.create');
Route::get('cursos/sesion/{id}', [SesionController::class, 'show'])->name('sesiones.show');
Route::get('cursos/sesion/{id}/editar', [SesionController::class, 'edit'])->name('sesiones.edit');
Route::get('cursos/sesion/{id}/ver', [SesionController::class, 'show'])->name('sesiones.show');
Route::put('cursos/sesion/{id}', [SesionController::class, 'update'])->name('sesiones.update');

Route::get('/recursos', [RecursoController::class, 'index'])->name('recursos.index');
Route::get('/recursos/{id}', [RecursoController::class, 'show'])->name('recursos.show');

});