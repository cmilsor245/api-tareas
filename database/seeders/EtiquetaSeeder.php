<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtiquetaSeeder extends Seeder {
  /**
   * run the database seeds
   */
  public function run(): void {
    DB::table('etiquetas') -> insert([
      'nombre' => 'trabajo'
    ]);

    DB::table('etiquetas') -> insert([
      'nombre' => 'personal'
    ]);

    DB::table('etiquetas') -> insert([
      'nombre' => 'salud'
    ]);

    DB::table('etiquetas') -> insert([
      'nombre' => 'hogar'
    ]);

    DB::table('etiquetas') -> insert([
      'nombre' => 'otros'
    ]);
  }
}