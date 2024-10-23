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
        Schema::create('producto', function (Blueprint $table) {
            $table->id('ID_PRODUCTO'); // Serial
            $table->string('NOMBRE_PRODUCTO'); // Nombre del producto
            $table->text('DESCRIPCION_PRODUCTO')->nullable(); // Descripción del producto
            $table->integer('MINIMO_PRODUCTO'); // Mínimo de producto
            $table->unsignedBigInteger('ID_TIPO_PRODUCTO'); // Foreign key
            $table->string('USUARIO_PRODUCTO'); // Usuario relacionado
            $table->timestamps(); // Fechas de creación y actualización

            $table->foreign('ID_TIPO_PRODUCTO')->references('ID_TIPO_PRODUCTO')->on('tipo_producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
