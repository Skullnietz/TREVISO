<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table      = 'empleado';
    protected $primaryKey = 'IDEmpleado';
    public    $timestamps = false;

    protected $fillable = [
        'NombreEmpleado','ApellidoPEmpleado','ApellidoMEmpleado',
        'CorreoEmpleado','TelefonoEmpleado','ActivoEmpleado','RutaEmpleado',
    ];

    public function getNombreCompletoAttribute(): string
    {
        return $this->NombreEmpleado . ' ' . $this->ApellidoPEmpleado . ' ' . $this->ApellidoMEmpleado;
    }

    public function usuario()
    {
        return $this->hasOne(UsuarioEmpleado::class, 'IDEmpleado', 'IDEmpleado');
    }

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'IDEmpleado', 'IDEmpleado');
    }
}