<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Cliente extends Model {
    protected $table = 'cliente'; protected $primaryKey = 'IDCliente'; public $timestamps = false;
    protected $fillable = ['NombreCliente','RutaCarpetaCliente','RFCCliente','ContactoCliente','TelefonoCliente','ActivoCliente','IDEmpleado'];
    public function empleado() { return $this->belongsTo(Empleado::class,'IDEmpleado','IDEmpleado'); }
    public function xmls() { return $this->hasMany(Xml::class,'IDCliente','IDCliente'); }
    public function depositos() { return $this->hasMany(DepositosCliente::class,'IDCliente','IDCliente'); }
    public function reembolsos() { return $this->hasMany(ReembolsosCliente::class,'IDCliente','IDCliente'); }
    public function bancos() { return $this->hasMany(BancoCliente::class,'IDCliente','IDCliente'); }
}