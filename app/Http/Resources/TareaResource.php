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
  public function toArray($request): array {
    $data = [
      'id' => $this -> id,
      'titulo' => $this -> titulo,
    ];

    if ($request -> has('descripcion')) {
      $data['descripcion'] = $this -> descripcion;
      $data['info-completa'] = $this -> titulo . ' - ' . $this -> descripcion;
    }

    if ($request -> has('etiquetas')) {
      $data['etiquetas'] = $this -> etiquetas -> pluck('nombre');
    }

    return $data;
  }
}