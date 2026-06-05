<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    protected $table = 'observaciones';

    protected $fillable = [
        'cfdi_id', 'cliente_auth_id', 'usuario_empleado_id',
        'mensaje', 'tipo', 'leida',
    ];

    protected $casts = [
        'leida' => 'boolean',
    ];

    public function cfdi()
    {
        return $this->belongsTo(Cfdi::class);
    }

    public function clienteAuth()
    {
        return $this->belongsTo(ClienteAuth::class);
    }

    public function usuarioEmpleado()
    {
        return $this->belongsTo(UsuarioEmpleado::class, 'usuario_empleado_id', 'IDUsuarioEmpleado');
    }
}
