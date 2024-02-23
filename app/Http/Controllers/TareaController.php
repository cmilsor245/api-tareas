<?php
namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Http\Requests\TareaRequest;

class TareaController extends Controller {
  /**
   * display a listing of the resource
   */
  public function index() {
    $tareas = Tarea::all();
    return $tareas;
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
  public function store(TareaRequest $request) {
    $tarea = Tarea::create($request -> all());
    return $tarea;
  }

  /**
   * display the specified resource
   */
  public function show(Tarea $tarea) {
    return $tarea;
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
  public function update(TareaRequest $request, Tarea $tarea) {
    $tarea -> update($request -> all());
    return $tarea;
  }

  /**
   * remove the specified resource from storage
   */
  public function destroy(Tarea $tarea) {
    $tarea -> delete();
    return $tarea;
  }
}