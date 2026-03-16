<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraAnio extends Model
{
    protected $table = 'extra_anio';
    protected $primaryKey = 'ID_Extra_Anio';
    public $timestamps = false;

    protected $fillable = [
        'Extra_Anio',
        'ID_Empleado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'ID_Empleado', 'ID_Empleado');
    }
}
