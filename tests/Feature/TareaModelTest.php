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

  /* ----------------------------------------------------------------------------------------------- */

  /* public function test_un_usuario_debe_estar_autenticado_para_crear_tareas() {
    $this -> expectException(\Illuminate\Auth\Access\AuthorizationException::class);

    Tarea::factory() -> create();
  } */

  public function test_se_crea_una_tarea_con_titulo_y_descripcion() {
    $tarea = Tarea::factory() -> create();

    $this -> assertDatabaseHas('tareas', [
      'titulo' => $tarea -> titulo,
      'descripcion' => $tarea -> descripcion
    ]);
  }

  public function test_se_crea_una_tarea_con_titulo_descripcion_y_etiquetas() {
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

  public function test_se_crea_una_tarea_solo_con_titulo() {
    $tarea = Tarea::factory() -> create([
      'descripcion' => null
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  public function test_no_se_puede_crear_una_tarea_sin_titulo() {
    $this -> expectException(\Illuminate\Database\QueryException::class);

    Tarea::factory() -> create([
      'titulo' => null
    ]);
  }

  public function test_se_puede_crear_una_tarea_sin_descripcion_y_con_etiquetas() {
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
}