<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\EtiquetaController;

Route::middleware('auth:sanctum') -> get('/user', function (Request $request) {
  return $request -> user();
});

Route::resource('/tareas', TareaController::class);
Route::resource('/etiquetas', EtiquetaController::class);