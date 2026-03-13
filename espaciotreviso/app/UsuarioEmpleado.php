<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioEmpleado extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarioempleado';
    protected $primaryKey = 'IDUsuarioEmpleado';
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'PassUsuarioEmpleado',
    ];

    /**
     * Overriding the getAuthPassword method since our password column has a custom name.
     */
    public function getAuthPassword()
    {
        return $this->PassUsuarioEmpleado;
    }
}
