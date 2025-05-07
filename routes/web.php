<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/panel', function () {
    return view('panel.login');
});
Route::get('/panel/index', function () {
    return view('panel.index');
});

Route::get('/panel/cursos', function () {
    return view('panel.cursos.index');
});

Route::get('/panel/estudiantes', function () {
    return view('panel.estudiantes.index');
});