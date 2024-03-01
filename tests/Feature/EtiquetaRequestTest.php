<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;

class EtiquetaRequestTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_crear_una_etiqueta_sin_nombre() {
    $etiqueta = Etiqueta::factory() -> make([
      'nombre' => null
    ]);

    $this -> assertDatabaseMissing('etiquetas', [
      'nombre' => $etiqueta -> nombre
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_acepta_un_parametro_nombre_de_3_caracteres_como_minimo() {
    $etiqueta = Etiqueta::factory() -> create([
      'nombre' => '123',
    ]);

    $this -> assertDatabaseHas('etiquetas', [
      'id' => $etiqueta -> id,
      'nombre' => $etiqueta -> nombre
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_acepta_un_parametro_nombre_de_50_caracteres_como_maximo() {
    $etiqueta = Etiqueta::factory() -> create([
      'nombre' => str_repeat('a', 50),
    ]);

    $this -> assertDatabaseHas('etiquetas', [
      'id' => $etiqueta -> id,
      'nombre' => $etiqueta -> nombre
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_correctamente_un_nombre_de_menos_de_3_caracteres() {
    $etiqueta = Etiqueta::factory() -> make([
      'nombre' => '12'
    ]);

    $this -> assertDatabaseMissing('etiquetas', [
      'id' => $etiqueta -> id,
      'nombre' => $etiqueta -> nombre
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_se_prohibe_correctamente_un_nombre_de_mas_de_50_caracteres() {
    $etiqueta = Etiqueta::factory() -> make([
      'nombre' => str_repeat('a', 51)
    ]);

    $this -> assertDatabaseMissing('etiquetas', [
      'id' => $etiqueta -> id,
      'nombre' => $etiqueta -> nombre
    ]);
  }
}