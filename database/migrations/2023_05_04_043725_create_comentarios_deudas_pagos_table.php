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
        Schema::create('comentarios_deudas_pagos', function (Blueprint $table) {
            $table->id();
            $table->text('contenido');
            $table->dateTime('fecha_comentario', $precision = 0);
            $table->enum('apartado', ['deudas', 'pagos']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_deudas_pagos');
    }
};
