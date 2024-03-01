<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;
use App\Models\Etiqueta;
use App\Http\Resources\TareaResource;
use Illuminate\Http\Request;

class TareaResourceTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_recurso_tarea_incluye_id_y_titulo_por_defecto() {
    $tarea = Tarea::factory() -> create();

    $resource = new TareaResource($tarea);

    $this -> assertEquals($tarea -> id, $resource['id']);
    $this -> assertEquals($tarea -> titulo, $resource['titulo']);
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_la_salida_de_una_tarea_utilizando_el_factory_general_incluye_titulo_descripcion() {
    $tarea = Tarea::factory() -> create();

    $resource = TareaResource::make($tarea);

    $this -> assertEquals($tarea -> titulo, $resource['titulo']);
    $this -> assertEquals($tarea -> descripcion, $resource['descripcion']);
  }
}