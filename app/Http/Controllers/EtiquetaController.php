<?php
namespace App\Http\Controllers;

use App\Models\Etiqueta;
use Illuminate\Http\Request;

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
  public function store(Request $request) {
    $etiqueta = new Etiqueta();
    $etiqueta -> fill($request -> all());
    $etiqueta -> save();
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
  public function update(Request $request, Etiqueta $etiqueta) {
    $etiqueta -> fill($request -> all());
    $etiqueta -> save();
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