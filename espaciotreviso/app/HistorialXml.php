<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class HistorialXml extends Model {
    protected $table = 'historialxml'; protected $primaryKey = 'IDHistoricoXML'; public $timestamps = false;
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}