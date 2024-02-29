<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;
use App\Http\Controllers\TareaController;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaControllerTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> seed();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_obtener_la_lista_completa_de_tareas() {
    $controller = new TareaController();

    $result = $controller -> index();

    $this -> assertInstanceOf(JsonResource::class, $result);
    $this -> assertCount(Tarea::count(), $result -> resource);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_crear_una_nueva_tarea() {
    $request = [
      'titulo' => '123',
      'descripcion' => '12345',
      'etiquetas' => [1, 2, 3]
    ];

    $response = $this -> post('/api/tareas', $request);

    $response -> assertStatus(200);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_obtener_la_informacion_de_una_tarea_concreta() {
    $tarea = Tarea::factory() -> create();
    $response = $this -> get('/api/tareas/' . $tarea -> id);
    $response -> assertStatus(200);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_actualizar_la_informacion_de_una_tarea() {
    $tarea = Tarea::factory() -> create();
    $response = $this -> put('/api/tareas/' . $tarea -> id, [
      'titulo' => '123',
      'descripcion' => '12345',
    ]);
    $response -> assertStatus(200);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_eliminar_una_tarea() {
    $tarea = Tarea::factory() -> create();
    $controller = new TareaController();

    $response = $controller -> destroy($tarea -> id);

    $this -> assertDatabaseMissing('tareas', ['id' => $tarea -> id]);
    $this -> assertEquals(200, $response -> getStatusCode());
    $this -> assertEquals('tarea eliminada', $response -> getData() -> message);
  }
}