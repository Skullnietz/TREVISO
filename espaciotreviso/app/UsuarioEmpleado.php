<?php
namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsuarioEmpleado extends Authenticatable
{
    use Notifiable;

    protected $table      = 'usuarioempleado';
    protected $primaryKey = 'IDUsuarioEmpleado';
    public    $timestamps = false;

    protected $fillable = [
        'NickUsuarioEmpleado',
        'PassUsuarioEmpleado',
        'ActivoUsuarioEmpleado',
        'IDRol',
        'IDEmpleado',
    ];

    protected $hidden = ['PassUsuarioEmpleado'];

    // Eloquent auth contracts
    public function getAuthIdentifierName() { return 'IDUsuarioEmpleado'; }
    public function getAuthPassword()       { return $this->PassUsuarioEmpleado; }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'IDEmpleado', 'IDEmpleado');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'IDRol', 'IDRol');
    }
}