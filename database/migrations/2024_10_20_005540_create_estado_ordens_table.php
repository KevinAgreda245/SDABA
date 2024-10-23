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
        Schema::create('estado_orden', function (Blueprint $table) {
            $table->id('ID_ESTADO_ORDEN'); // Serial
            $table->string('ESTADO_ORDEN'); // String
            $table->timestamps();
        });

        // // Insertar los estados por defecto
        // DB::table('ESTADO_ORDEN')->insert([
        //     ['ESTADO_ORDEN' => 'Autorizada'],
        //     ['ESTADO_ORDEN' => 'Denegada'],
        //     ['ESTADO_ORDEN' => 'Pendiente'],
        //     ['ESTADO_ORDEN' => 'Registrada'],
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_orden');
    }
};
