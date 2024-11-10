<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//Spatie, modelo para permisos se esta agregando
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Definición de los permisos
        $permisos = [
            //Tabla roles
            'ver-rol',
            'crear-rol',
            'editar-rol',
            'borrar-rol',
        ];
        //Se añadiran los permisos a la tabla de permisos de spatie
        foreach($permisos as $permiso){
            Permission::create(['name'=>$permiso]);
        }
    }
}
