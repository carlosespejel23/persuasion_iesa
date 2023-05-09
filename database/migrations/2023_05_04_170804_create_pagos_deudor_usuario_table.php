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
        Schema::create('pagos_deudor_usuario', function (Blueprint $table) {
            $table->unsignedBigInteger('pago_id');
            $table->foreign('pago_id', 'fk_pdu_pago')->references('id')->on('pagos')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('deudor_id');
            $table->foreign('deudor_id', 'fk_pdu_deudor')->references('id')->on('deudores')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_pdu_usuario')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos_deudor_usuario');
    }
};
