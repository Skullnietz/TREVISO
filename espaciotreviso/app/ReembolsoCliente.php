<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReembolsoCliente extends Model
{
    protected $table = 'reembolsoscliente';
    protected $primaryKey = 'IDReembolsoCliente';
    public $timestamps = false;
}
