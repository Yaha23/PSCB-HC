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
        Schema::table('users', function (Blueprint $table) {
            $table->string('surname')->after('name')->nullable();
            $table->string('phone', 9)->after('surname')->nullable();
            $table->enum('status', ['activo', 'inactivo'])->after('phone')->default('activo');
            $table->enum('role', ['administrador', 'asistente', 'medico'])->after('status')->default('asistente');
            $table->string('specialty')->after('role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn(['surname', 'phone', 'status', 'role', 'specialty']);
        });
    }
};
