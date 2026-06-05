<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'rfc', 'razon_social', 'regimen_fiscal',
        'cer_path', 'key_path', 'key_password',
        'efirma_vigencia', 'efirma_uploaded_at', 'activo',
    ];

    protected $hidden = ['key_password'];

    protected $casts = [
        'efirma_vigencia' => 'date',
        'efirma_uploaded_at' => 'datetime',
        'activo' => 'boolean',
    ];

    public function setKeyPasswordAttribute($value)
    {
        $this->attributes['key_password'] = $value ? encrypt($value) : null;
    }

    public function getKeyPasswordAttribute($value)
    {
        return $value ? decrypt($value) : null;
    }

    public function tieneEfirmaValida()
    {
        return $this->cer_path
            && $this->key_path
            && $this->key_password
            && $this->efirma_vigencia
            && $this->efirma_vigencia->isFuture();
    }

    public function cfdis()
    {
        return $this->hasMany(Cfdi::class);
    }

    public function clienteAuth()
    {
        return $this->hasOne(ClienteAuth::class);
    }

    public function solicitudesDescarga()
    {
        return $this->hasMany(SolicitudDescarga::class);
    }
}
