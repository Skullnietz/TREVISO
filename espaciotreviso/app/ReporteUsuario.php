<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReporteUsuario extends Model
{
    protected $table = 'reporte_usuario';
    protected $primaryKey = 'ID_Reporte_Usuario';
    public $timestamps = false;

    protected $fillable = [
        'Fecha_Reporte_Usuario',
        'Comentario_Reporte_Usuario',
        'Mes_Reporte',
        'Anio_Reporte',
        'ID_Usuario',
        'ID_Empresa',
        'ID_Actividad',
    ];

    protected $casts = [
        'Fecha_Reporte_Usuario' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(UsuarioEmpleado::class, 'ID_Usuario', 'ID_Usuario');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'ID_Empresa', 'ID_Empresa');
    }

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'ID_Actividad', 'ID_Actividad');
    }
}
