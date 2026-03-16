<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class ComplementoPago extends Model {
    protected $table = 'complementopago'; protected $primaryKey = 'IDComplementoPago'; public $timestamps = false;
    protected $fillable = ['UUID','SerieXML','FolioXML','EmisorXML','FechaEmisionXML','ReceptorXML','FormaPagoXML','RutaCarpetaXML','IDCliente','MontoPagoXML'];
    public function cliente() { return $this->belongsTo(Cliente::class,'IDCliente','IDCliente'); }
}