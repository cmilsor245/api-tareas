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
      'access_token' => $token,
      'token_type' => 'Bearer'
    ]);
  }
}