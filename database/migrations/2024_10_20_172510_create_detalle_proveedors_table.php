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
        Schema::create('detalle_proveedor', function (Blueprint $table) {
            $table->id('ID_DETALLE_PROVEEDOR'); // Serial
            $table->foreignId('ID_PRODUCTO')->constrained('producto', 'ID_PRODUCTO')->onDelete('cascade'); // Foreign key to producto
            $table->foreignId('ID_PROVEEDOR')->constrained('proveedor', 'id_proveedor')->onDelete('cascade'); // Foreign key to proveedor
            $table->decimal('PRECIO_PROVEEDOR', 10, 2); // Decimal
            $table->boolean('PREFERIDO_PROVEEDOR')->default(false); // Boolean
            $table->string('USUARIO_DET_USUARIO'); // String
            $table->timestamps(); // Timestamps para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_proveedor');
    }
};
