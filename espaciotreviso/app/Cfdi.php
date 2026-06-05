<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cfdi extends Model
{
    protected $table = 'cfdis';

    protected $fillable = [
        'cliente_id', 'uuid', 'rfc_emisor', 'nombre_emisor',
        'rfc_receptor', 'nombre_receptor', 'tipo', 'categoria',
        'tipo_comprobante', 'monto_total', 'moneda', 'fecha_emision',
        'fecha_timbrado', 'metodo_pago', 'forma_pago', 'serie', 'folio',
        'estatus_sat', 'estatus_pago', 'metodo_pago_real',
        'fecha_pago', 'referencia_pago', 'xml_path', 'solicitud_descarga_id',
    ];

    protected $casts = [
        'fecha_emision' => 'datetime',
        'fecha_timbrado' => 'datetime',
        'fecha_pago' => 'date',
        'monto_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function solicitudDescarga()
    {
        return $this->belongsTo(SolicitudDescarga::class);
    }

    public function observaciones()
    {
        return $this->hasMany(Observacion::class, 'cfdi_id');
    }

    public function scopeIngresos($query)
    {
        return $query->where('categoria', 'factura_ingreso');
    }

    public function scopeEgresos($query)
    {
        return $query->where('categoria', 'factura_egreso');
    }

    public function scopeNotasCredito($query)
    {
        return $query->where('categoria', 'nota_credito');
    }

    public function scopeComplementosPago($query)
    {
        return $query->where('categoria', 'complemento_pago');
    }

    public function scopeNominas($query)
    {
        return $query->where('categoria', 'nomina');
    }

    public function scopeBanco($query)
    {
        return $query->whereIn('forma_pago', ['02', '03', '04', '05', '28', '29']);
    }
}
