<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositoCliente extends Model
{
    protected $table = 'depositoscliente';
    protected $primaryKey = 'IDDepositoCliente';
    public $timestamps = false;
}
