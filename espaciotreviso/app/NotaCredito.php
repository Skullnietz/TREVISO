<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class NotaCredito extends Model {
    protected $table = 'notacredito'; protected $primaryKey = 'IDNotaCredito'; public $timestamps = false;
    protected $fillable = ['UUID','SerieXML','FolioXML','EmisorXML','FechaEmisionXML','ReceptorXML','FormaPagoXML','RutaCarpetaXML','ContabilizadoXML','EditableXML','IDCliente','MontoPagoXML','SaldadoXML','MetodoPagoXML','IDSaldado','FechaConta'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}