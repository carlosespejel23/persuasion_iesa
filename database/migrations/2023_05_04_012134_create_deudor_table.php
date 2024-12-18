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
        Schema::create('deudores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_usuario_deudor')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->string('nombre', 50);
            $table->string('apellidoPaterno', 50);
            $table->string('apellidoMaterno', 50);
            $table->string('email')->unique();
            $table->string('telefono', 10);
            $table->string('curp',18)->nullable();
            $table->string('rfc',13)->nullable();
            $table->string('nacionalidad');
            $table->decimal('monto_a_pagar', $precision = 10, $scale = 2);
            $table->decimal('monto_pagado', $precision = 10, $scale = 2)->default('0.00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deudores');
    }
};
