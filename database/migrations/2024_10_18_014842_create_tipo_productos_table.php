<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_producto', function (Blueprint $table) {
            $table->id('ID_TIPO_PRODUCTO'); // Primary Key
            $table->string('NOMBRE_TIPO_PRODUCTO'); // Nombre del tipo de producto
            $table->text('DESCR_TIPO_PRODUCTO')->nullable(); // Descripción del tipo de producto
            $table->timestamps(); // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_producto');
    }
};
