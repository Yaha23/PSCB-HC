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
            $table->foreignId('asistente_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('especialidad');
            $table->date('fecha_atencion');
            $table->time('hora_atencion')->nullable();
            $table->text('motivo_consulta')->nullable();
            $table->string('tiempo_enfermedad')->nullable();
            $table->string('apetito')->nullable();
            $table->string('sed')->nullable();
            $table->string('sueno')->nullable();
            $table->string('estado_animo')->nullable();
            $table->string('orina')->nullable();
            $table->string('deposiciones')->nullable();
            $table->text('diagnostico_principal')->nullable();
            $table->text('tratamiento')->nullable();
            $table->text('acuerdos_compromisos')->nullable();
            $table->text('examenes_auxiliares')->nullable();
            $table->text('referencia')->nullable();
            $table->text('observaciones')->nullable();
            $table->enum('estado', ['pendiente','revision','finalizada'])->default('pendiente');
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