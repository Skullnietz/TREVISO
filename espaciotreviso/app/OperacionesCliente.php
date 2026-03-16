<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class OperacionesCliente extends Model {
    protected $table = 'operacionescliente'; protected $primaryKey = 'IDOperacionN'; public $timestamps = false;
    protected $fillable = ['FechaOperacionN','DescripcionOperacionN','MontoOperacionN','BancoOrigen','CuentaOrigen','BancoDestino','CuentaDestino','Referencia','Contabilizado','FechaConta','IDCliente','IDEmpleado','Observaciones','TransP','ReemDep','IDReemDep'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}