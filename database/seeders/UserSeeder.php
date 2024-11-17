<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asumiendo que el ID del rol administrador es 1 (ajusta si es necesario)
        $role = Rol::where('DESCRIPCION_ROL', 'Administrador')->first(); 

        // Crear el usuario administrador con la contraseña 'admin'
        User::create([
            'NOMBRE_USUARIO' => 'Administrador',
            'APELLIDO_USUARIO' => 'Sistema',
            'USER_USUARIO' => 'admin',
            'CLAVE_USUARIO' => bcrypt('admin'), // Encriptar la contraseña
            'ID_ROL' => $role ? $role->ID_ROL : 1, // Si no existe el rol, se asigna el ID 1 por defecto
        ]);
    }
}
