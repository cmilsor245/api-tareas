<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * run the migrations.
   */
  public function up(): void {
    Schema::create('tarea_etiqueta', function (Blueprint $table) {
      $table -> id();
      $table -> unsignedBigInteger('tarea_id');
      $table -> unsignedBigInteger('etiqueta_id');
      $table -> timestamps();

      $table -> foreign('tarea_id') -> references('id') -> on('tareas') -> onDelete('cascade');
      $table -> foreign('etiqueta_id') -> references('id') -> on('etiquetas') -> onDelete('cascade');
    });
  }

  /**
   * reverse the migrations.
   */
  public function down(): void {
    Schema::dropIfExists('tarea_etiqueta');
  }
};