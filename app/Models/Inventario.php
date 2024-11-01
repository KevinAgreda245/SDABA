<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'inventario';

    // Llave primaria
    protected $primaryKey = 'ID_INVENTARIO';

    public $timestamps = true; // Usar timestamps

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'CANTIDAD_INVENTARIO',
        'PRECIO_INVENTARIO',
        'COSTO_INVENTARIO',
        'ID_PRODUCTO',
        'USUARIO_PRODUCTO',
        'ESTADO_ACTIVO_INVENTARIO',
    ];

    // Relación con el modelo Producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_PRODUCTO');
    }
}
