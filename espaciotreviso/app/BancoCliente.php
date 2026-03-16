<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class BancoCliente extends Model {
    protected $table = 'bancocliente'; protected $primaryKey = 'IDBancoCliente'; public $timestamps = false;
    protected $fillable = ['TerminacionBancoCliente','NombreBanco','IDCliente','TipoBanco'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}