<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDespacho extends Model
{
    use HasFactory;

    protected $table = 'detalle_despacho';
    protected $primaryKey = 'ID_DETALLE_DESPACHO';

    protected $fillable = [
        'ID_DESPACHO',
        'ID_PRODUCTO',
        'CANTIDAD',
        'COSTO_PRODUCTO',
        'PRECIO_PRODUCTO',
    ];

    // Relación con despacho
    public function despacho()
    {
        return $this->belongsTo(Despacho::class, 'ID_DESPACHO', 'ID_DESPACHO');
    }

    // Relación con productos
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_PRODUCTO', 'ID_PRODUCTO');
    }
}
