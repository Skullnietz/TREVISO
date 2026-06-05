<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class ClienteAuth extends Authenticatable
{
    protected $table = 'clientes_auth';

    protected $fillable = [
        'cliente_id', 'email', 'password', 'activo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'ultimo_acceso' => 'datetime',
        'activo' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function observaciones()
    {
        return $this->hasMany(Observacion::class);
    }
}
