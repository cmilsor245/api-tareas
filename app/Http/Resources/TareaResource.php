<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TareaResource extends JsonResource {
  /**
   * transform the resource into an array
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array {
    return [
      'id' => $this -> id,
      'titulo' => $this -> titulo,
      'descripcion' => $this -> descripcion,
      'info-completa' => $this -> titulo . ' - ' . $this -> descripcion
    ];
  }
}