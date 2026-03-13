<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodopago';
    protected $primaryKey = 'IDMetodoPago';
    public $timestamps = false;
}
