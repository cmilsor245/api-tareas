<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller {
  public function signup(Request $request) {
    $usuario = User::create([
      'name' => $request -> name,
      'email' => $request -> email,
      'password' => Hash::make($request -> password)
    ]);

    $token = $usuario -> createToken('authToken') -> plainTextToken;

    return response() -> json([
      'data' => $usuario,
      'token_de_acceso' => $token,
      'token_type' => 'Bearer'
    ]);
  }

  public function login(Request $request) {
    $usuario = User::where('email', $request -> email) -> first();

    if (!$usuario || !Hash::check($request -> password, $usuario -> password)) {
      return response() -> json([
        'message' => 'credenciales incorrectas'
      ], 401);
    }

    $token = $usuario -> createToken('authToken') -> plainTextToken;

    return response() -> json([
      'message' => '¡hola ' . $usuario -> name . '!',
      'token_de_acceso' => $token,
      'token_type' => 'Bearer'
    ]);
  }

  public function logout() {
    auth() -> user() -> tokens() -> delete();
    return response() -> json(['message' => 'sesión cerrada correctamente']);
  }
}