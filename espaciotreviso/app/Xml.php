<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Xml extends Model
{
    protected $table = 'xml';
    protected $primaryKey = 'IDXML';
    public $timestamps = false;
}
