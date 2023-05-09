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
        Schema::create('cad_usuarios_deudores', function (Blueprint $table) {
            $table->unsignedBigInteger('comentarioAD_id');
            $table->foreign('comentarioAD_id', 'fk_cad_comentarioAD')->references('id')->on('comentarios_actualizar_deudas')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_cad_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('deudor_id');
            $table->foreign('deudor_id', 'fk_cad_deudor')->references('id')->on('deudores')->onDelete('cascade')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cad_usuarios_deudores');
    }
};
