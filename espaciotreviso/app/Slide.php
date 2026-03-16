<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Slide extends Model {
    protected $table = 'slide'; protected $primaryKey = 'IDSlide'; public $timestamps = false;
    protected $fillable = ['DescripcionSlide','TipoSlide','RutaSlide','ActivoSlide','OrdenSlide'];
}