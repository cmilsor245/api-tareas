<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Etiqueta;

class TareaModelTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_tarea() {
    $tarea = Tarea::factory() -> create();

    $this -> assertDatabaseHas('tareas', [
      'titulo' => $tarea -> titulo,
      'descripcion' => $tarea -> descripcion
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_tarea_con_etiquetas() {
    $etiquetas = Etiqueta::factory() -> count(2) -> create();
    $tarea = Tarea::factory() -> create();
    $tarea -> etiquetas() -> attach($etiquetas -> pluck('id'));

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo,
      'descripcion' => $tarea -> descripcion
    ]);

    foreach ($etiquetas as $etiqueta) {
      $this -> assertDatabaseHas('tarea_etiqueta', [
        'tarea_id' => $tarea -> id,
        'etiqueta_id' => $etiqueta -> id,
      ]);
    }
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_tarea_solo_con_titulo() {
    $tarea = Tarea::factory() -> create([
      'descripcion' => null
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_no_se_puede_crear_una_tarea_sin_titulo() {
    $this -> expectException(\Illuminate\Database\QueryException::class);

    Tarea::factory() -> create([
      'titulo' => null
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_tarea_con_etiquetas_y_sin_descripcion() {
    $etiquetas = Etiqueta::factory() -> count(2) -> create();
    $tarea = Tarea::factory() -> create([
      'descripcion' => null
    ]);
    $tarea -> etiquetas() -> attach($etiquetas -> pluck('id'));

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);

    foreach ($etiquetas as $etiqueta) {
      $this -> assertDatabaseHas('tarea_etiqueta', [
        'tarea_id' => $tarea -> id,
        'etiqueta_id' => $etiqueta -> id,
      ]);
    }
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_no_se_pueden_asociar_etiquetas_inexistentes_a_una_tarea() {
    $this -> expectException(\Illuminate\Database\QueryException::class);

    $tarea = Tarea::factory() -> create();
    $tarea -> etiquetas() -> attach([
      999,
      1000
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_asocian_las_etiquetas_validas_y_se_descartan_las_inexistentes() {
    $this -> expectException(\Illuminate\Database\QueryException::class);

    $etiquetas = Etiqueta::factory() -> count(2) -> create();
    $tarea = Tarea::factory() -> create();
    $tarea -> etiquetas() -> attach($etiquetas -> pluck('id'));
    $tarea -> etiquetas() -> attach([
      999,
      1000
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);

    foreach ($etiquetas as $etiqueta) {
      $this -> assertDatabaseHas('tarea_etiqueta', [
        'tarea_id' => $tarea -> id,
        'etiqueta_id' => $etiqueta -> id,
      ]);
    }
  }
}