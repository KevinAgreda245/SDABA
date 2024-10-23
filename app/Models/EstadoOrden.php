<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    use HasFactory;

    protected $table = 'estado_orden'; // Nombre de la tabla
    protected $primaryKey = 'ID_ESTADO_ORDEN'; // Clave primaria
    public $timestamps = true; // Usar timestamps

    protected $fillable = ['estado_orden']; // Campos que se pueden llenar
}
