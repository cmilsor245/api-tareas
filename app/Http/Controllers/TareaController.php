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
    $tarea = Tarea::create($request -> all());
    return new TareaResource($tarea);
  }

  /**
   * display the specified resource
   */
  public function show(Tarea $tarea): JsonResource {
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
  public function update(TareaRequest $request, Tarea $tarea): JsonResource {
    $tarea -> update($request -> all());
    return new TareaResource($tarea);
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy(Tarea $tarea) {
    $tarea -> delete();
    return $tarea;
  }
}