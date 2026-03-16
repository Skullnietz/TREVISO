<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class SolicitudEdicionObjeto extends Model {
    protected $table = 'solicitudedicionobjeto'; protected $primaryKey = 'IDSolicitud'; public $timestamps = false;
    protected $fillable = ['IDObjeto','IDCliente','IDEmpleado','Atendida','Observaciones','FechaCaptura','ComentariosClientes','Tipo'];
}