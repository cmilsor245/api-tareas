<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TareaSeeder extends Seeder {
  /**
   * run the database seeds
   */
  public function run(): void {
    DB::table('tareas') -> insert([
      'titulo' => 'test tarea 1',
      'descripcion' => 'test tarea 1 descripción'
    ]);

    DB::table('tareas') -> insert([
      'titulo' => 'test tarea 2',
      'descripcion' => 'test tarea 2 descripción'
    ]);

    DB::table('tareas') -> insert([
      'titulo' => 'test tarea 3',
      'descripcion' => 'test tarea 3 descripción'
    ]);

    DB::table('tareas') -> insert([
      'titulo' => 'test tarea 4',
      'descripcion' => 'test tarea 4 descripción'
    ]);

    DB::table('tareas') -> insert([
      'titulo' => 'test tarea 5',
      'descripcion' => 'test tarea 5 descripción'
    ]);
  }
}