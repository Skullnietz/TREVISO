<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaqueteDescarga extends Model
{
    protected $table = 'paquetes_descarga';

    protected $fillable = [
        'solicitud_descarga_id', 'id_paquete', 'estado',
        'zip_path', 'cfdis_count', 'error_mensaje',
    ];

    public function solicitudDescarga()
    {
        return $this->belongsTo(SolicitudDescarga::class);
    }
}
