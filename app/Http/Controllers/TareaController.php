<?php
namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\TareaRequest;
use App\Http\Resources\TareaResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Etiqueta;

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

    if ($request -> has('etiquetas')) {
      $etiquetas_existentes = $this -> obtenerEtiquetasExistentes($request -> etiquetas);

      $tarea -> etiquetas() -> attach($etiquetas_existentes);

      $response = [
        'tarea' => new TareaResource($tarea),
      ];

      if (count($etiquetas_existentes) < count($request -> etiquetas)) {
        $etiquetas_inexistentes = array_diff($request -> etiquetas, $etiquetas_existentes);
        $response['message'] = 'algunas etiquetas no existen y no fueron agregadas: ' . implode(', ', $etiquetas_inexistentes);
      }
    } else {
      $response = [
        'tarea' => new TareaResource($tarea),
      ];
    }

    return new JsonResource($response);
  }

  /**
   * display the specified resource
   */
  public function show($id) {
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response() -> json(['message' => 'tarea no encontrada'], 404);
    }
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
    if (!$tarea) {
        return new JsonResource(['message' => 'tarea no encontrada'], 404);
    }

    $tarea -> titulo = $request -> titulo;
    $tarea -> descripcion = $request -> descripcion;
    $tarea -> etiquetas() -> detach();

    if ($request -> has('etiquetas')) {
      $etiquetas_existentes = $this -> obtenerEtiquetasExistentes($request -> etiquetas);

      $tarea -> etiquetas() -> attach($etiquetas_existentes);

      $response = [
        'tarea' => new TareaResource($tarea),
      ];

      if (count($etiquetas_existentes) < count($request -> etiquetas)) {
        $etiquetas_inexistentes = array_diff($request -> etiquetas, $etiquetas_existentes);
        $response['message'] = 'algunas etiquetas no existen y no fueron agregadas: ' . implode(', ', $etiquetas_inexistentes);
      }
    } else {
      $response = [
        'tarea' => new TareaResource($tarea),
      ];
    }

    return new JsonResource($response);
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy($id) {
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response() -> json(['message' => 'tarea no encontrada'], 404);
    }
    $tarea -> delete();
    return response() -> json(['message' => 'tarea eliminada'], 200);
  }

  /**
   * obtiene las etiquetas existentes en la base de datos dada una lista de ids
   */
  private function obtenerEtiquetasExistentes(array $etiquetas): array {
    return Etiqueta::whereIn('id', $etiquetas) -> pluck('id') -> all();
  }
}