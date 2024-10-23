<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProveedor extends Model
{
    use HasFactory;

    protected $table = 'detalle_proveedor'; // Nombre de la tabla
    protected $primaryKey = 'ID_DETALLE_PROVEEDOR'; // Clave primaria
    public $timestamps = true; // Usar timestamps

    protected $fillable = [
        'ID_PRODUCTO', 
        'ID_PROVEEDOR', 
        'PRECIO_PROVEEDOR', 
        'PREFERIDO_PROVEEDOR', 
        'USUARIO_DET_USUARIO'
    ]; // Campos que se pueden llenar

    // Definición de relaciones
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'ID_PRODUCTO');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'ID_PROVEEDOR');
    }
}
