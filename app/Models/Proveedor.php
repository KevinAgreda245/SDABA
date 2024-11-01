<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor'; // Nombre de la tabla
    protected $primaryKey = 'ID_PROVEEDOR'; // Clave primaria
    public $timestamps = true; // Usar timestamps

    protected $fillable = [
        'NOMBRE_PROVEEDOR', 
        'CORREO_PROVEEDOR',
        'TELEFONO_PROVEEDOR',  
        'DIRECCION_PROVEEDOR', 
        'USUARIO_PROVEEDOR'
    ];
}
