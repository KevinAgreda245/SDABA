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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('ID_USUARIO'); // Primary Key
            $table->string('NOMBRE_USUARIO'); // Nombre del usuario
            $table->string('APELLIDO_USUARIO'); // Apellido del usuario
            $table->string('USER_USUARIO')->unique(); // Username del usuario
            $table->text('CLAVE_USUARIO'); // Clave del usuario
            $table->unsignedBigInteger('ID_ROL'); // Foreign Key para rol
            $table->timestamps();

            // Definir claves foráneas
            $table->foreign('ID_ROL')->references('ID_ROL')->on('rol')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
