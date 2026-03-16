<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $primaryKey = 'ID_Empresa';
    public $timestamps = false;

    protected $fillable = [
        'Nombre_Empresa',
        'ID_Empleado',
        'Status_Empresa',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'ID_Empleado', 'ID_Empleado');
    }

    public function reportes()
    {
        return $this->hasMany(ReporteUsuario::class, 'ID_Empresa', 'ID_Empresa');
    }
}
