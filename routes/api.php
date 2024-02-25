<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EtiquetaController;
use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum') -> get('/user', function (Request $request) {
  return $request -> user();
});

Route::post('/registro', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum') -> group(function () {
  Route::get('/salir', [AuthController::class, 'logout']);

  Route::resource('/tareas', TareaController::class);
  Route::resource('/etiquetas', EtiquetaController::class);
});