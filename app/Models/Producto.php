<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Definir la tabla correspondiente
    protected $table = 'producto'; 
    protected $primaryKey = 'ID_PRODUCTO'; // Clave primaria
    public $timestamps = true; // Si usas timestamps


    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'NOMBRE_PRODUCTO',
        'DESCRIPCION_PRODUCTO',
        'MINIMO_PRODUCTO',
        'ID_TIPO_PRODUCTO',
        'USUARIO_PRODUCTO',
    ];

    // Definir la relación con el modelo TipoProducto 
    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'ID_TIPO_PRODUCTO');
    }
}
