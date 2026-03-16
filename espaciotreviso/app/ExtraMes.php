<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtraMes extends Model
{
    protected $table = 'extra_mes';
    protected $primaryKey = 'ID_Extra_Mes';
    public $timestamps = false;

    protected $fillable = [
        'Extra_Mes',
        'ID_Empleado',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'ID_Empleado', 'ID_Empleado');
    }
}
