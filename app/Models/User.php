<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Especificar la tabla que usará este modelo
    protected $table = 'usuario';

    // Especificar la clave primaria de la tabla
    protected $primaryKey = 'ID_USUARIO';

    // Los campos que pueden ser llenados de forma masiva
    protected $fillable = [
        'NOMBRE_USUARIO',
        'APELLIDO_USUARIO',
        'USER_USUARIO',
        'CLAVE_USUARIO',
        'ID_ROL',
    ];

    // Relación con la tabla 'roles'
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'ID_ROL');
    }
}
