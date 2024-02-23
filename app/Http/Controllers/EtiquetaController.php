<?php
namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Http\Requests\EtiquetaRequest;
use App\Http\Resources\EtiquetaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class EtiquetaController extends Controller {
  /**
   * display a listing of the resource
   */
  public function index(): JsonResource {
    $etiquetas = Etiqueta::all();
    return EtiquetaResource::collection($etiquetas);
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
  public function store(EtiquetaRequest $request): JsonResource {
    $etiqueta = Etiqueta::create($request -> all());
    return new EtiquetaResource($etiqueta);
  }

  /**
   * display the specified resource
   */
  public function show(Etiqueta $etiqueta): JsonResource {
    return new EtiquetaResource($etiqueta);
  }

  /**
   * show the form for editing the specified resource
   */
  public function edit(Etiqueta $etiqueta) {
    //
  }

  /**
   * update the specified resource in storage
   */
  public function update(EtiquetaRequest $request, Etiqueta $etiqueta): JsonResource {
    $etiqueta -> update($request -> all());
    return new EtiquetaResource($etiqueta);
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy(Etiqueta $etiqueta) {
    $etiqueta -> delete();
    return $etiqueta;
  }
}