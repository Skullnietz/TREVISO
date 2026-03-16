<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Xml extends Model {
    protected $table = 'xml'; protected $primaryKey = 'IDXML'; public $timestamps = false;
    protected $fillable = ['UUID','SerieXML','FolioXML','EmisorXML','FechaEmisionXML','ReceptorXML','FormaPagoXML','RutaCarpetaXML','ContabilizadoXML','EditableXML','IDCliente','MontoPagoXML','SaldadoXML','MetodoPagoXML','ObservacionesEmpleadoXML','ObservacionesAdministradorXML','IDSaldado','FechaConta','TipoXML'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
    public function metodopago() { return $this->belongsTo(MetodoPago::class,'FormaPagoXML','IDMetodoPago'); }
}