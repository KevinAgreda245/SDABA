<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Agregar esta línea

class EstadoOrdenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('estado_orden')->insert([
            ['ESTADO_ORDEN' => 'Autorizada'],
            ['ESTADO_ORDEN' => 'Denegada'],
            ['ESTADO_ORDEN' => 'Pendiente'],
            ['ESTADO_ORDEN' => 'Registrada'],
        ]);
    }
}
