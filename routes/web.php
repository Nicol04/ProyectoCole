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