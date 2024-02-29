<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class TareaControllerTest extends TestCase {
  use RefreshDatabase;

  public function setUp(): void {
    parent::setUp();
    $this -> actingAs(User::factory() -> create());
  }

  /* ------------------------------------------------------------------------------------------------------- */

  public function test_obtener_la_lista_completa_de_tareas() {
    $this -> artisan('db:seed');

    $response = $this -> get('/api/tareas');
    $response -> assertStatus(200);
    $response -> assertJsonCount(5, 'data');
  }
}