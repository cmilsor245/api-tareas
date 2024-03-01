<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Tarea;
use App\Models\Etiqueta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tarea>
 */
class TareaFactory extends Factory {
  protected $model = Tarea::class;

  /**
   * define the model's default state
   *
   * @return array<string, mixed>
   */
  public function definition(): array {
    return [
      'titulo' => $this -> faker -> sentence(),
      'descripcion' => $this -> faker -> paragraph()
    ];
  }

  public function configure() {
    return $this -> afterCreating(function (Tarea $tarea) {
      $etiquetas = Etiqueta::factory() -> count(rand(1, 3)) -> create();
      $tarea -> etiquetas() -> attach($etiquetas);

      $info_completa = $tarea -> titulo . ' - ' . $tarea -> descripcion;
      $tarea -> update(['info-completa' => $info_completa]);
    });
  }
}