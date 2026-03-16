<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class DepositosCliente extends Model {
    protected $table = 'depositoscliente'; protected $primaryKey = 'IDDeposito'; public $timestamps = false;
    protected $fillable = ['IDDepositoCliente','NombreBancoDeposito','ReferenciaBancoDeposito','TerminacionBancoDeposito','IDCliente','TotalDepositoReal','TotalDeposito','FechaDeposito','ObservacionesDeposito','Activo','Contabilizado','FechaConta'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}