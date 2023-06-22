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
        Schema::create('comentarios_actualizar_deudas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_cad_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('deudor_id');
            $table->foreign('deudor_id', 'fk_cad_deudor')->references('id')->on('deudores')->onDelete('cascade')->onUpdate('restrict');
            $table->string('comentario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comentarios_actualizar_deuda');
    }
};
