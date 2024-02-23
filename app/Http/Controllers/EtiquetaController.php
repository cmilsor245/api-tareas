<?php
namespace App\Http\Controllers;

use App\Models\Etiqueta;
use App\Http\Requests\EtiquetaRequest;

class EtiquetaController extends Controller {
  /**
   * display a listing of the resource
   */
  public function index() {
    $etiquetas = Etiqueta::all();
    return $etiquetas;
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
  public function store(EtiquetaRequest $request) {
    $etiqueta = Etiqueta::create($request -> all());
    return $etiqueta;
  }

  /**
   * display the specified resource
   */
  public function show(Etiqueta $etiqueta) {
    return $etiqueta;
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
  public function update(EtiquetaRequest $request, Etiqueta $etiqueta) {
    $etiqueta -> update($request -> all());
    return $etiqueta;
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy(Etiqueta $etiqueta) {
    $etiqueta -> delete();
    return $etiqueta;
  }
}