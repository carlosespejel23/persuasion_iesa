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
        Schema::create('users_historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nombre', 50);
            $table->string('apellidoPaterno', 50);
            $table->string('apellidoMaterno', 50);
            $table->string('telefono', 10);
            $table->date('fecha_de_nacimiento');
            $table->string('email')->unique();
            $table->string('nacionalidad');
            $table->date('fecha_baja');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_historial');
    }
};
