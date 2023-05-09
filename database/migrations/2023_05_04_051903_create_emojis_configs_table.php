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
        Schema::create('emojis_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id', 'fk_emojis_usuario')->references('id')->on('users')->onDelete('cascade')->onUpdate('restrict');
            $table->string('enojo', 30);
            $table->string('like', 30);
            $table->string('comentar', 30);
            $table->string('compartir', 30);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emojis_configs');
    }
};
