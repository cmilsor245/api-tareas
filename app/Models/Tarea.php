<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model {
  use HasFactory;

  protected $guarded = [];
  protected $fillable = [
    'titulo',
    'descripcion'
  ];
  protected $hidden = [
    'created_at',
    'updated_at'
  ];
  protected $table = 'tareas';

  public function etiquetas() {
    return $this -> belongsToMany(Etiqueta::class, 'tarea_etiqueta', 'tarea_id', 'etiqueta_id');
  }
}