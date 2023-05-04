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
        Schema::create('cdp_deudor_usuario', function (Blueprint $table) {
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_cdp_usuario')->references('id')->on('usuarios')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('deudor_id');
            $table->foreign('deudor_id', 'fk_cdp_deudor')->references('id')->on('deudores')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('comentarioDP_id');
            $table->foreign('comentarioDP_id', 'fk_cdp_comentarioDP')->references('id')->on('comentarios_deudas_pagos')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cdp_deudor_usuario');
    }
};
