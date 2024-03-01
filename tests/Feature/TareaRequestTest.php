<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Etiqueta;

class TareaRequestTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_crear_una_tarea_sin_titulo() {
    $tarea = Tarea::factory() -> make([
      'titulo' => null
    ]);

    $this -> assertDatabaseMissing('tareas', [
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_acepta_un_parametro_titulo_de_3_caracteres_como_minimo() {
    $tarea = Tarea::factory() -> create([
      'titulo' => '123',
      'descripcion' => null
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_acepta_un_parametro_titulo_de_50_caracteres_como_maximo() {
    $tarea = Tarea::factory() -> create([
      'titulo' => str_repeat('a', 50),
      'descripcion' => null
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_correctamente_un_titulo_de_menos_de_3_caracteres() {
    $tarea = Tarea::factory() -> make([
      'titulo' => '12',
      'descripcion' => null
    ]);

    $this -> assertDatabaseMissing('tareas', [
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_correctamente_un_titulo_de_mas_de_50_caracteres() {
    $tarea = Tarea::factory() -> make([
      'titulo' => str_repeat('a', 56),
      'descripcion' => null
    ]);

    $this -> assertDatabaseMissing('tareas', [
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_puede_crear_una_tarea_con_una_descripcion_de_5_caracteres() {
    $tarea = Tarea::factory() -> create([
      'descripcion' => '12345'
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_puede_crear_una_tarea_con_una_descripcion_de_255_caracteres() {
    $tarea = Tarea::factory() -> create([
      'descripcion' => str_repeat('a', 255)
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_crear_una_tarea_con_una_descripcion_de_menos_de_5_caracteres() {
    $tarea = Tarea::factory() -> make([
      'descripcion' => '1234'
    ]);

    $this -> assertDatabaseMissing('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_crear_una_tarea_con_una_descripcion_de_mas_de_255_caracteres() {
    $tarea = Tarea::factory() -> make([
      'descripcion' => str_repeat('a', 256)
    ]);

    $this -> assertDatabaseMissing('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_es_posible_crear_una_tarea_sin_descripcion() {
    $tarea = Tarea::factory() -> create([
      'descripcion' => null
    ]);

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_es_posible_crear_una_tarea_sin_descripcion_pero_con_etiquetas() {
    $etiquetas = Etiqueta::factory() -> count(3) -> create();
    $tarea = Tarea::factory() -> create([
      'descripcion' => null,
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

  public function test_es_posible_crear_una_tarea_con_descripcion_pero_sin_etiquetas() {
    $tarea = Tarea::factory() -> create();

    $this -> assertDatabaseHas('tareas', [
      'id' => $tarea -> id,
      'titulo' => $tarea -> titulo
    ]);
  }
}