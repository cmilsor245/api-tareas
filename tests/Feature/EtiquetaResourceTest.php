<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;
use App\Http\Resources\EtiquetaResource;

class EtiquetaResourceTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_recurso_etiqueta_incluye_id_y_nombre_por_defecto() {
    $etiqueta = Etiqueta::factory() -> create();

    $resource = new EtiquetaResource($etiqueta);

    $this -> assertEquals($etiqueta -> id, $resource['id']);
    $this -> assertEquals($etiqueta -> nombre, $resource['nombre']);
  }
}