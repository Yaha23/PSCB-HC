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
       Schema::create('signos_vitales', function (Blueprint $table) {
            $table->id();

            $table->foreignId('consulta_id')->constrained()->onDelete('cascade');

            $table->decimal('peso', 5, 2);
            $table->decimal('talla', 5, 2);
            $table->string('presion_arterial');
            $table->integer('frecuencia_cardiaca');
            $table->decimal('temperatura', 4, 1);
            $table->integer('frecuencia_respiratoria');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signos_vitales');
    }
};
