<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividad';
    protected $primaryKey = 'ID_Actividad';
    public $timestamps = false;

    protected $fillable = [
        'Descripcion_Actividad',
        'ID_Rol',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'ID_Rol', 'ID_Rol');
    }

    public function reportes()
    {
        return $this->hasMany(ReporteUsuario::class, 'ID_Actividad', 'ID_Actividad');
    }
}
