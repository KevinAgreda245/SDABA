<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'orden_compra';

    // Llave primaria
    protected $primaryKey = 'ID_ORDEN_COMPRA';

    public $timestamps = true; // Usar timestamps

    // Campos que pueden ser asignados en masa
    protected $fillable = [
        'FECHA_COMPRA',
        'ID_ESTADO_ORDEN',
        'ID_PROVEEDOR',
        'FECHA_ENTREGA',
        'USUARIO_ORDEN_COMPRA',
    ];

    // Relación con el modelo EstadoOrden
    public function estadoOrden()
    {
        return $this->belongsTo(EstadoOrden::class, 'ID_ESTADO_ORDEN');
    }

    // Relación con el modelo Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ID_PROVEEDOR');
    }    
}
