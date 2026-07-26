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

            //==========================
            // RELACIONES
            //==========================
            $table->foreignId('paciente_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('medico_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->foreignId('asistente_id')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

            //==========================
            // DATOS GENERALES
            //==========================
            $table->string('especialidad');

            $table->date('fecha_atencion');

            $table->time('hora_atencion')->nullable();

            //==========================
            // ANAMNESIS
            //==========================
            $table->text('motivo_consulta')->nullable();

            $table->string('tiempo_enfermedad')->nullable();

            $table->string('apetito')->nullable();

            $table->string('sed')->nullable();

            $table->string('sueno')->nullable();

            $table->string('estado_animo')->nullable();

            $table->string('orina')->nullable();

            $table->string('deposiciones')->nullable();

        

            //==========================
            // DIAGNÓSTICO
            //==========================
            $table->text('diagnostico_principal')->nullable();

            //==========================
            // TRATAMIENTO
            //==========================
            $table->text('tratamiento')->nullable();

            //==========================
            // ACUERDOS
            //==========================
            $table->text('acuerdos_compromisos')->nullable();

            //==========================
            // EXÁMENES
            //==========================
            $table->text('examenes_auxiliares')->nullable();

            //==========================
            // REFERENCIA
            //==========================
            $table->text('referencia')->nullable();

          

            //==========================
            // OBSERVACIONES
            //==========================
            $table->text('observaciones')->nullable();

            //==========================
            // ESTADO DE LA CONSULTA
            //==========================
            $table->enum('estado', [
                'pendiente',
                'revision',
                'finalizada'
            ])->default('pendiente');

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