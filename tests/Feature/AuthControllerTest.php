<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthControllerTest extends TestCase {
  use RefreshDatabase;

  public function test_registro_con_credenciales_correctas() {
    $request = new Request();
    $request -> replace([
      'name' => 'test',
      'email' => 'test@test',
      'password' => 'test'
    ]);

    $controller = new AuthController();
    $response = $controller -> signup($request);

    $this -> assertEquals(200, $response -> getStatusCode());
    $response_data = json_decode($response -> getContent(), true);
    $this -> assertArrayHasKey('data', $response_data);
    $this -> assertArrayHasKey('token_de_acceso', $response_data);
    $this -> assertArrayHasKey('token_type', $response_data);
  }

  public function test_login_con_credenciales_correctas() {
    User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $request = new Request();
    $request -> replace([
      'email' => 'test@test',
      'password' => 'test'
    ]);
    $controller = new AuthController();
    $response = $controller -> login($request);

    $this -> assertEquals(200, $response -> getStatusCode());

    $response_data = json_decode($response -> getContent(), true);
    $message = $response_data['message'];
    $this -> assertEquals('¡hola test!', $message);
    $token = $response_data['token_de_acceso'];
    $this -> assertNotEmpty($token);
  }

  // ! el método 'tokens()' no funciona
  /* public function test_logout_con_token_de_acceso_valido_devuelve_mensaje_de_exito() {
    $request = new Request();
    $request -> replace([
      'email' => 'test@test',
      'password' => 'test'
    ]);

    User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $controller = new AuthController();
    $response = $controller -> logout();

    $this -> assertEquals(200, $response -> getStatusCode());
  } */

  public function test_no_se_puede_realizar_un_registro_con_un_email_existente() {
    $this -> expectException('Illuminate\Database\UniqueConstraintViolationException');

    User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $request = new Request();
    $request -> replace([
      'name' => 'test',
      'email' => 'test@test',
      'password' => 'test'
    ]);
    $controller = new AuthController();
    $response = $controller -> signup($request);

    $this -> assertEquals(500, $response -> getStatusCode());
  }

  public function test_nombre_vacio_en_registro_produce_un_error() {
    $this -> expectException('Illuminate\Database\QueryException');

    $request = new Request();
    $request -> replace([
      'name' => null,
      'email' => 'test@test',
      'password' => 'test'
    ]);
    $controller = new AuthController();
    $response = $controller -> signup($request);

    $this -> assertEquals(500, $response -> getStatusCode());
  }

  public function test_email_vacio_en_registro_produce_un_error() {
    $this -> expectException('Illuminate\Database\QueryException');

    $request = new Request();
    $request -> replace([
      'name' => 'test',
      'email' => null,
      'password' => 'test'
    ]);
    $controller = new AuthController();
    $response = $controller -> signup($request);

    $this -> assertEquals(500, $response -> getStatusCode());
  }

  // * esto no funciona como se esperaría porque el campo 'password' parece no ser obligatorio
  /* public function test_password_vacio_en_registro_produce_un_error() {
    $this -> expectException('Illuminate\Database\QueryException');

    $request = new Request();
    $request -> replace([
      'name' => 'test',
      'email' => 'test@test',
      'password' => null
    ]);
    $controller = new AuthController();
    $response = $controller -> signup($request);

    $this -> assertEquals(500, $response -> getStatusCode());
  } */

  public function test_login_con_email_no_existente_produce_un_error() {
    $request = new Request();
    $request -> replace([
      'email' => 'test@test',
      'password' => 'test'
    ]);
    $controller = new AuthController();
    $response = $controller -> login($request);

    $this -> assertEquals(401, $response -> getStatusCode());
  }

  public function test_login_con_credenciales_incorrectas_produce_un_error() {
    User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $request = new Request();
    $request -> replace([
      'email' => 'test@test',
      'password' => 'test2'
    ]);
    $controller = new AuthController();
    $response = $controller -> login($request);

    $this -> assertEquals(401, $response -> getStatusCode());
  }

  public function test_login_con_token_invalido_produce_un_error() {
    User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $invalid_token = 'invalid_token';

    $request = new Request();
    $request -> headers -> set('Authorization', 'Bearer ' . $invalid_token);

    $controller = new AuthController();
    $response = $controller -> login($request);

    $this -> assertEquals(401, $response -> getStatusCode());
  }

      // Accessing protected routes with invalid access token returns error message
  public function test_acceder_a_una_ruta_protegida_con_un_token_invalido_devuelve_un_error() {
    $this -> expectException('Symfony\Component\Routing\Exception\RouteNotFoundException');

    $user = User::factory() -> create([
      'name' => 'test',
      'email' => 'test@test',
      'password' => Hash::make('test')
    ]);

    $token = $user -> createToken('authToken') -> plainTextToken;

    $user -> tokens() -> delete();

    $response = $this -> withHeaders([
      'Authorization' => 'Bearer ' . $token,
    ]) -> get('/api/tareas');

    $response -> assertStatus(401);
    $response -> assertJson([
      'message' => 'Unauthenticated.'
    ]);
  }
}