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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id('ID_INVENTARIO'); // Serial
            $table->integer('CANTIDAD_INVENTARIO'); // Int
            $table->decimal('PRECIO_INVENTARIO', 10, 2); // Decimal
            $table->decimal('COSTO_INVENTARIO', 10, 2); // Decimal
            $table->unsignedBigInteger('ID_PRODUCTO'); // Foreign Key
            $table->string('USUARIO_INVENTARIO')->nullable(); // String
            $table->string('ESTADO_ACTIVO_INVENTARIO')->default('Activo'); // string
            $table->timestamps();
    
            $table->foreign('ID_PRODUCTO')->references('ID_PRODUCTO')->on('producto')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
