<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
    $table->id();

    $table->foreignId('paciente_id')->constrained()->onDelete('cascade');
    $table->foreignId('medico_id')->constrained('users')->onDelete('cascade');

    $table->string('especialidad');
    $table->date('fecha_atencion');

    $table->text('diagnostico_principal')->nullable();
    $table->text('tratamiento')->nullable();

    // 🔥 CLAVE DEL FLUJO
    $table->enum('estado', ['pendiente','revision','finalizada'])
          ->default('pendiente');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
