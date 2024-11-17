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
        Schema::create('despacho', function (Blueprint $table) {
            $table->id('ID_DESPACHO'); // PK
            $table->datetime('FECHA_DESPACHO'); // Fecha y hora del despacho
            $table->unsignedBigInteger('ID_USUARIO'); // FK hacia usuarios
            $table->timestamps();

            // Relación con usuarios
            $table->foreign('ID_USUARIO')->references('ID_USUARIO')->on('usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('despacho');
    }
};
