<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model {
  use HasFactory;

  protected $guarded = [];
  protected $fillable = [
    'nombre'
  ];
  protected $hidden = [
    'created_at',
    'updated_at'
  ];
  protected $table = 'etiquetas';
}