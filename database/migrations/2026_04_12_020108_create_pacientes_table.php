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
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();

            $table->string('nombres');
            $table->string('apellidos');
            $table->string('DNI')->unique();
            $table->date('fecha_nacimiento');
            $table->string('genero');           
            $table->string('estado_civil')->nullable();
            $table->string('celular');
            $table->string('email')->unique();
            $table->string('direccion');
            $table->string('grupo_sanguineo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
