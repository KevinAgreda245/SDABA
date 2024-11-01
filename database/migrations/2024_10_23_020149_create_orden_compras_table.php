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
        Schema::create('orden_compra', function (Blueprint $table) {
            $table->id('ID_ORDEN_COMPRA'); // Serial (primary key)
            $table->date('FECHA_COMPRA'); // Fecha de la compra
            $table->unsignedBigInteger('ID_ESTADO_ORDEN'); // Foreign key hacia estado_orden
            $table->unsignedBigInteger('ID_PROVEEDOR') ->nullable(); // Foreign key hacia proveedor
            $table->date('FECHA_ENTREGA')->nullable(); // Fecha de entrega (opcional)
            $table->string('USUARIO_ORDEN_COMPRA')->nullable(); // Usuario que realizó la compra
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('ID_ESTADO_ORDEN')->references('ID_ESTADO_ORDEN')->on('estado_orden')->onDelete('cascade');
            $table->foreign('ID_PROVEEDOR')->references('ID_PROVEEDOR')->on('proveedor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_compra');
    }
};
