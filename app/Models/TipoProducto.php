<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoProducto extends Model
{
    use HasFactory;

    protected $table = 'tipo_producto'; // Especificar el nombre de la tabla
    protected $primaryKey = 'ID_TIPO_PRODUCTO'; // Clave primaria

    protected $fillable = [
        'NOMBRE_TIPO_PRODUCTO',
        'DESCR_TIPO_PRODUCTO',
    ];

    public $timestamps = true; // Si usas timestamps
}
