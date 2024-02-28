<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;

class TareaModelTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ----------------------------------------------------------------------------------------------- */

  public function test_se_crea_una_tarea_con_titulo_y_descripcion() {
    $tarea = new Tarea();
    $tarea -> titulo = 'test';
    $tarea -> descripcion = 'test';
    $tarea -> save();

    $this -> assertDatabaseHas('tareas', [
      'titulo' => 'test',
      'descripcion' => 'test'
    ]);
  }

  public function test_se_crea_una_tarea_solo_con_titulo() {
    $tarea = new Tarea();
    $tarea -> titulo = 'test';
    $tarea -> save();

    $this -> assertDatabaseHas('tareas', [
      'titulo' => 'test'
    ]);
  }

  public function test_no_se_puede_crear_una_tarea_sin_titulo() {
    $response = $this -> postJson('/api/tareas', [
      'descripcion' => 'test'
    ]);

    $response -> assertStatus(422);
  }
}