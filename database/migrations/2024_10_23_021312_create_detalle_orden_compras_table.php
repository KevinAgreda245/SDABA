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
        Schema::create('detalle_orden', function (Blueprint $table) {
            $table->id('ID_DETALLE_ORDEN'); // Primary Key
            $table->unsignedBigInteger('ID_ORDEN_COMPRA'); // Foreign Key
            $table->unsignedBigInteger('ID_PRODUCTO'); // Foreign Key
            $table->integer('CANTIDAD_PRODUCTO'); // Cantidad del producto
            $table->decimal('COSTO_PRODUCTO', 10, 2); // Costo del producto
            $table->decimal('PRECIO_PRODUCTO', 10, 2); // Precio del producto
            $table->string('USUARIO_ORDEN_COMPRA'); // Usuario que gestiona la orden
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('ID_ORDEN_COMPRA')->references('ID_ORDEN_COMPRA')->on('orden_compra')->onDelete('cascade');
            $table->foreign('ID_PRODUCTO')->references('ID_PRODUCTO')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_orden');
    }
};
