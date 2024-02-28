<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Etiqueta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etiqueta>
 */
class EtiquetaFactory extends Factory {
  protected $model = Etiqueta::class;

  /**
   * define the model's default state
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'nombre' => $this -> faker -> word()
    ];
  }
}