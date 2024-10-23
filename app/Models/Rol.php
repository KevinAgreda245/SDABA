<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'rol'; // Especificar el nombre de la tabla
    protected $primaryKey = 'ID_ROL'; // Clave primaria

    protected $fillable = [
        'DESCRIPCIÓN'
    ];
    public $timestamps = true; // Si usas timestamps

}
