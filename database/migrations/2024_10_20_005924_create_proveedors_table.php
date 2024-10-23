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
        Schema::create('proveedor', function (Blueprint $table) {
            $table->id('ID_PROVEEDOR'); // Serial
            $table->string('NOMBRE_PROVEEDOR'); // String
            $table->string('CONTACTO_PROVEEDOR'); // String
            $table->text('DIRECCION_PROVEEDOR')->nullable(); // Text
            $table->string('USUARIO_PROVEEDOR'); // String
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedor');
    }
};
