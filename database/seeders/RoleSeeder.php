<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insertar roles de ejemplo
        Rol::create([
            'DESCRIPCION_ROL' => 'Administrador',
        ]);

        Rol::create([
            'DESCRIPCION_ROL' => 'Gestor de Inventario',
        ]);

        Rol::create([
            'DESCRIPCION_ROL' => 'Gerente de Almacen',
        ]);
    }
}
