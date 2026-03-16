<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ReembolsosCliente extends Model {
    protected $table = 'reembolsoscliente'; protected $primaryKey = 'IDReembolso'; public $timestamps = false;
    protected $fillable = ['IDReembolsoCliente','NombreBancoReembolso','ReferenciaBancoReembolso','TerminacionBancoReembolso','IDCliente','TotalReembolsoReal','TotalReembolso','FechaReembolso','ObservacionesReembolso','Activo','Contabilizado','FechaConta'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}