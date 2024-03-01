<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;
use App\Http\Controllers\EtiquetaController;
use Illuminate\Http\Resources\Json\JsonResource;

class EtiquetaControllerTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> seed();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_obtener_la_lista_completa_de_etiquetas() {
    $controller = new EtiquetaController();

    $result = $controller -> index();

    $this -> assertInstanceOf(JsonResource::class, $result);
    $this -> assertCount(Etiqueta::count(), $result -> resource);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_obtener_la_informacion_de_una_etiqueta_concreta() {
    $etiqueta = Etiqueta::factory() -> create();
    $response = $this -> get('/api/etiquetas/' . $etiqueta -> id);
    $response -> assertStatus(200);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_actualizar_la_informacion_de_una_etiqueta() {
    $etiqueta = Etiqueta::factory() -> create();
    $response = $this -> put('/api/etiquetas/' . $etiqueta -> id, [
      'nombre' => '123',
    ]);
    $response -> assertStatus(200);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_eliminar_una_etiqueta() {
    $etiqueta = Etiqueta::factory() -> create();
    $controller = new EtiquetaController();

    $response = $controller -> destroy($etiqueta -> id);

    $this -> assertDatabaseMissing('etiquetas', ['id' => $etiqueta -> id]);
    $this -> assertEquals(200, $response -> getStatusCode());
    $this -> assertEquals('etiqueta eliminada', $response -> getData() -> message);
  }
}