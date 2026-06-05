<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolicitudDescarga extends Model
{
    protected $table = 'solicitudes_descarga';

    protected $fillable = [
        'cliente_id', 'tipo', 'fecha_inicio', 'fecha_fin',
        'request_id', 'estado', 'paquetes_total', 'paquetes_descargados',
        'cfdis_procesados', 'error_mensaje', 'automatica',
        'solicitada_at', 'completada_at',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'solicitada_at' => 'datetime',
        'completada_at' => 'datetime',
        'automatica' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function paquetes()
    {
        return $this->hasMany(PaqueteDescarga::class);
    }

    public function cfdis()
    {
        return $this->hasMany(Cfdi::class);
    }
}
