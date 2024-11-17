<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{
    use HasFactory;

    protected $table = 'despacho';
    protected $primaryKey = 'ID_DESPACHO';

    protected $fillable = [
        'FECHA_DESPACHO',
        'ID_USUARIO',
    ];

    // Relación con usuarios
    public function usuario()
    {
        return $this->belongsTo(User::class, 'ID_USUARIO', 'ID_USUARIO');
    }

    // Relación con detalle de despachos
    public function detalles()
    {
        return $this->hasMany(DetalleDespacho::class, 'ID_DESPACHO', 'ID_DESPACHO');
    }
}
