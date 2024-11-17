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
        Schema::create('detalle_despacho', function (Blueprint $table) {
            $table->id('ID_DETALLE_DESPACHO'); // PK
            $table->unsignedBigInteger('ID_DESPACHO'); // FK hacia despachos
            $table->unsignedBigInteger('ID_PRODUCTO'); // FK hacia productos
            $table->integer('CANTIDAD'); // Cantidad de productos
            $table->decimal('COSTO_PRODUCTO', 10, 2); // Costo del producto
            $table->decimal('PRECIO_PRODUCTO', 10, 2); // Precio del producto
            $table->timestamps();

            // Relación con despachos
            $table->foreign('ID_DESPACHO')->references('ID_DESPACHO')->on('despacho')->onDelete('cascade');

            // Relación con productos
            $table->foreign('ID_PRODUCTO')->references('ID_PRODUCTO')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_despacho');
    }
};
