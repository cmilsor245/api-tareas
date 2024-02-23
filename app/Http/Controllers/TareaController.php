<?php
namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaController extends Controller {
  /**
   * display a listing of the resource
   */
  public function index(): JsonResource {
    $tareas = Tarea::all();
    return TareaResource::collection($tareas);
  }

  /**
   * show the form for creating a new resource
   */
  public function create() {
    //
  }

  /**
   * store a newly created resource in storage
   */
  public function store(TareaRequest $request): JsonResource {
    $tarea = new Tarea();
    $tarea -> titulo = $request -> titulo;
    $tarea -> descripcion = $request -> descripcion;
    $tarea -> save();
    $tarea -> etiquetas() -> attach($request -> etiquetas);
    return new TareaResource($tarea);
  }

  /**
   * display the specified resource
   */
  public function show($id): JsonResource {
    $tarea = Tarea::find($id);
    return new TareaResource($tarea);
  }

  /**
   * show the form for editing the specified resource
   */
  public function edit(Tarea $tarea) {
    //
  }

  /**
   * update the specified resource in storage
   */
  public function update(TareaRequest $request, $id): JsonResource {
    $tarea = Tarea::find($id);
    $tarea -> titulo = $request -> titulo;
    $tarea -> descripcion = $request -> descripcion;
    $tarea -> etiquetas() -> detach();
    $tarea -> etiquetas() -> attach($request -> etiquetas);
    $tarea -> save();
    return new TareaResource($tarea);
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy($id) {
    $tarea = Tarea::find($id);
    if ($tarea) {
      $tarea -> delete();
      return response() -> json(["message" => "tarea eliminada"], 204);
    } else {
      return response() -> json(["message" => "tarea no encontrada"], 404);
    }
  }
}