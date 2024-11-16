<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenCompra extends Model
{
    use HasFactory;

    protected $table = 'detalle_orden';

    protected $primaryKey = 'ID_DETALLE_ORDEN';

    protected $fillable = [
        'ID_ORDEN_COMPRA',
        'ID_PRODUCTO',
        'CANTIDAD_PRODUCTO',
        'COSTO_PRODUCTO',
        'PRECIO_PRODUCTO',
        'USUARIO_ORDEN_COMPRA',
    ];

    public $timestamps = true;

    public function producto()
{
    return $this->belongsTo(Producto::class, 'ID_PRODUCTO', 'ID_PRODUCTO');
}
}
