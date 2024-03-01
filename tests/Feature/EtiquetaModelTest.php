<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;

class EtiquetaModelTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_etiqueta() {
    $etiqueta = Etiqueta::factory() -> create();

    $this -> assertDatabaseHas('etiquetas', [
      'nombre' => $etiqueta -> nombre
    ]);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_no_se_puede_crear_una_etiqueta_sin_nombre() {
    $this -> expectException(\Illuminate\Database\QueryException::class);

    Etiqueta::factory() -> create([
      'nombre' => null
    ]);

    $this -> assertDatabaseMissing('etiquetas', [
      'nombre' => null
    ]);
  }
}